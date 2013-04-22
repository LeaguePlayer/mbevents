(function($) {
    $(document).ready(function() {
        var playersManager = new PlayersManager;
    });    
    
})(jQuery);


function PlayersManager() {
    if ( undefined !== PlayersManager.instance )
        return PlayersManager.instance;
        
    this._players = {};
    this.settings = {
        playerClass: 'player',
        streamSource: 'source',
        imageSource: 'image'
    };
    
    this.initPlayer = function(settings) {
        var s = $.extend({
            element: '',
            source: '',
            image: '',
            width: 940,
            height: 300,
            provider: 'video',
            write: 'mediaspace'
        }, settings || {});
        
        var manager = this;        
        jwplayer(s.element).setup({
            file: s.source,
            image: s.image,
            width: s.width,
            height: s.height,
            provider: s.provider,
            write: s.write,
        });
        jwplayer(s.element).onPlay(function() {
            manager.pausePlayers(s.element);
        });
        this._players[s.element] = true; //true или false здесь роли не играет, важен только факт наличия элемента s.element в массиве _players
    }
    
    this.initPlayerByElementAttributes = function(element) {
        var el = $(element);
        var settings = {
            element: el.attr('id'),
            source: el.data(this.settings.streamSource),
            image: el.data(this.settings.imageSource),
            width: el.data('width'),
            height: el.data('height'),
        };
        this.initPlayer(settings);
    }
    
    this.initPlayersInHtml = function(html) {
        var playerContainers = $(html).find('.' + this.settings.playerClass);
        var manager = this;
        playerContainers.each(function() {
            manager.initPlayerByElementAttributes(this);
        });
    }
    
    this.pausePlayers = function(unsafeElement) {
        for ( var key in this._players ) {
            if ( key != unsafeElement ) {
                jwplayer(key).pause(true);
            }
        }
    }
    
    this.removePlayer = function(element) {
        if ( this._players[element] == true ) {
            jwplayer(element).remove();
            delete this._players.element;
        }
    }
    
    this.init = function() {
        var manager = this;
        $('.' + this.settings.playerClass).each(function() {
            manager.initPlayerByElementAttributes(this);
        });
    }
    
    this.init();
    PlayersManager.instance = this;
}