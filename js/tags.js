$(document).ready(function() {
    var availableTags = [];
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    $.ajax({
        url: "/tag/load/",
        type: "GET",
        dataType: "json",
        success: function(data) {
            for (key in data) {
                availableTags.push(data[key]);
            }
            $( "#Article_tags" )
                .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "ui-autocomplete" ).menu.active ) {
                      event.preventDefault();
                    }
                })
            .autoResize()
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                    response( $.ui.autocomplete.filter(availableTags, extractLast( request.term ) ) );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
        }
    });
});