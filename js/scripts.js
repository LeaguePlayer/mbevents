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
        }, settings || {});
        
        console.log(settings);
        
        var manager = this;        
        jwplayer(s.element).setup({
            file: s.source,
            image: s.image,
            provider: 'video',
            write: 'mediaspace',
        });
        jwplayer(s.element).onPlay(function() {
            manager.pausePlayers(s.element);
        });
        this._players[s.element] = true;
    }
    
    this.initPlayerByElementAttributes = function(element) {
        var el = $(element);
        var settings = {
            element: el.attr('id'),
            source: el.attr(this.settings.streamSource),
            image: el.attr(this.settings.imageSource),
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
        jwplayer(element).remove();
        delete this._players.element;
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