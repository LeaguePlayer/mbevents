<?php

Yii::import('xupload.actions.XUploadAction');

class UploadAction extends XUploadAction {
    public function init( ) {
        if( !isset( $this->path ) ) {
            $this->path = realpath( Yii::app( )->getBasePath( )."/../uploads" );
        }

        if( !is_dir( $this->path ) ) {
            mkdir( $this->path, 0777, true );
            chmod ( $this->path , 0777 );
            //throw new CHttpException(500, "{$this->path} does not exists.");
        } else if( !is_writable( $this->path ) ) {
            chmod( $this->path, 0777 );
            //throw new CHttpException(500, "{$this->path} is not writable.");
        }
        
//        if( $this->subfolderVar !== null && $this->subfolderVar !== false ) {
//            $this->_subfolder = Yii::app( )->request->getQuery( $this->subfolderVar, date( "mdY" ) );
//        } else if( $this->subfolderVar !== false ) {
//            $this->_subfolder = date( "mdY" );
//        }

        if( !isset($this->_formModel)) {
            $this->formModel = Yii::createComponent(array('class'=>$this->formClass));
        }

        if($this->secureFileNames) {
            $this->formModel->secureFileNames = true;
        }
    }
    
    
    protected function handleUploading()
    {
        $this->init();
        $model = $this->formModel;
        $model->{$this->fileAttribute} = CUploadedFile::getInstance($model, $this->fileAttribute);
        if ($model->{$this->fileAttribute} !== null) {
            $model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->getType();
            $model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->getSize();
            $model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->getName();
            $model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

            if ($model->validate()) {

                $path = $this->getPath();

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }
                
                $filename = Functions::translit($model->{$this->fileNameAttribute});

                $model->{$this->fileAttribute}->saveAs($path . $filename);
                chmod($path . $filename, 0777);

                $returnValue = $this->beforeReturn();
                if ($returnValue === true) {
                    echo json_encode(array(array(
                        "name" => $model->{$this->displayNameAttribute},
                        "type" => $model->{$this->mimeTypeAttribute},
                        "size" => $model->{$this->sizeAttribute},
                        "url" => $this->getFileUrl($filename),
                        "thumbnail_url" => $model->getThumbnailUrl($this->getPublicPath()),
                        "delete_url" => $this->getController()->createUrl($this->getId(), array(
                            "_method" => "delete",
                            "file" => $filename,
                        )),
                        "delete_type" => "POST"
                    )));
                } else {
                    echo json_encode(array(array("error" => $returnValue,)));
                    Yii::log("XUploadAction: " . $returnValue, CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
                }
            } else {
                echo json_encode(array(array("error" => $model->getErrors($this->fileAttribute),)));
                Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
            }
        } else {
            throw new CHttpException(500, "Could not upload file");
        }
    }
}