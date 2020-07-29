'use strict';
class ViewEpisode {
    constructor() {
        this.seasons = [];
        this.serialId = $('.title__text').attr('data-serial-id');
    }
    createSeasonStructure() {
        $('.season__view-episode').each((i, e) => {
            let seasonNumber = veObject.getSeasonNumber.bind(e)();
            if (!(seasonNumber in veObject.seasons)) {
                veObject.seasons[seasonNumber] = {};
                veObject.seasons[seasonNumber].episodes = [];
                veObject.seasons[seasonNumber].episodesNumTotal = 0;
            }
            veObject.seasons[seasonNumber].episodesNumTotal++;
        });
    }
    addEpisode(season, newEpisode) {
        if (this.seasons[season].episodes.indexOf(newEpisode) == -1) {
            this.seasons[season].episodes.push(newEpisode);
            this.drawProgressLine(season);
        } else return false;
    }
    removeEpisode(remEpisode) {
        let flag = false;
        this.seasons.forEach((season, seasonNumber) => {
            let episodeIndex = season.episodes.indexOf(remEpisode);
            if (episodeIndex != -1) {
                season.episodes.splice(episodeIndex, 1);
                this.drawProgressLine(seasonNumber);
                flag = true;
            }
        });
        return flag;
    }
    getSerialId() {
        return +$('.serial__title-subscribe').attr('data-serial-id');
    }
    getSeasonNumber() {
        return +$(this).attr('data-season-number');
    }
    getEpisodeId() {
        return +$(this).attr('data-episode-id');
    }
    subscribeSerial() {
        let request = $.ajax({
            method: 'PUT',
            url: 'http://localhost:8000/api/track-serial/add',
            data: {
                serial: [this.getSerialId()]
            }
        });
        request.done((response) => {
            $('.serial__title-subscribe').removeClass('serial__title-subscribe_follow_off').addClass('serial__title-subscribe_follow_on');
            console.log('Subscribed to the serial #' + this.getSerialId());
        });
    }
    unSubscribeSerial() {
        let request = $.ajax({
            method: 'DELETE',
            url: 'http://localhost:8000/api/track-serial/delete',
            data: {
                serial: [this.getSerialId()]
            }
        });
        request.done((response) => {
            $('.serial__title-subscribe').removeClass('serial__title-subscribe_follow_on').addClass('serial__title-subscribe_follow_off');
            console.log('Unsubscribed from the serial #' + this.getSerialId());
        });
    }
    watchEpisode(viewButton) {
        let episodeId = this.getEpisodeId.bind(viewButton)();
        let seasonNumber = this.getSeasonNumber.bind(viewButton)();
        if (this.addEpisode(seasonNumber, episodeId) != false) {
            let request = $.ajax({
                method: 'PUT',
                url: 'http://localhost:8000/api/view-episode/add',
                data: {
                    episode: [episodeId]
                }
            });
            request.done(() => {
                $(viewButton).addClass('season__view-episode_subscribed');
                console.log('Watched the episode #' + episodeId);
            });
        }
    }
    notWatchEpisode(viewButton) {
        let episodeId = this.getEpisodeId.bind(viewButton)();
        if (this.removeEpisode(episodeId) != false) {
            let request = $.ajax({
                method: 'DELETE',
                url: 'http://localhost:8000/api/view-episode/delete',
                data: {
                    episode: [episodeId]
                }
            });
            request.done(() => {
                $(viewButton).removeClass('season__view-episode_subscribed');
                console.log('Haven`t watched the episode #' + episodeId);
            });
        }
    }
    isSubscribed() {
        let request = $.ajax({
            method: 'GET',
            url: 'http://localhost:8000/api/track-serial',
            data: {
                serial: this.getSerialId()
            }
        });
        request.done(() => {
            $('.serial__title-subscribe').removeClass('serial__title-subscribe_follow_off').addClass('serial__title-subscribe_follow_on');
        });
    }
    isWatched() {
        let request = $.ajax({
            method: 'GET',
            url: 'http://localhost:8000/api/view-episode',
            data: {
                serial: this.getSerialId()
            }
        });
        request.done((response) => {
            response.response.forEach((row) => {
                this.addEpisode(row.seasonNumber, row.episodeId);
                $(`#episode-${row.episodeId}`).addClass('season__view-episode_subscribed');
            });
        });
    }
    drawProgressLine(season) {
        let watchedPercent = veObject.seasons[season].episodes.length / veObject.seasons[season].episodesNumTotal * 100;
        $(`div[data-content="#season-${season}"] ~ div.season__progressbar div.season__progressbar-progress`)[0].style.width = watchedPercent + '%';
    }
}
let veObject = new ViewEpisode;
veObject.createSeasonStructure();
veObject.isSubscribed();
veObject.isWatched();
// подписаться/отписаться на сериал
$('.serial__title-subscribe').on('click', function() {
    if ($(this).hasClass('serial__title-subscribe_follow_off')) {
        veObject.subscribeSerial();
    } else {
        veObject.unSubscribeSerial();
    }
});
// смотрел/не смотрел сезон
$('.season__view-multiple').on('click', function() {
    let season = veObject.getSeasonNumber.bind(this)();
    if ($(this).hasClass('season__view-multiple_direction_left')) {
        console.group('Watched the season #' + season);
        $(`#season-${season} .season__view-episode`).each(function() {
            veObject.watchEpisode(this);
        });
        console.groupEnd();
    } else {
        console.group('Haven`t watched the season #' + season);
        $(`#season-${season} .season__view-episode`).each(function() {
            veObject.notWatchEpisode(this);
        });
        console.groupEnd();
    }
});
// смотрел/не смотрел эпизод
$('.season__view-episode').on('click', function() {
    if ($(this).hasClass('season__view-episode_subscribed')) {
        veObject.notWatchEpisode(this);
    } else {
        veObject.watchEpisode(this);
    }
});