'use strict';
$(function() {
    //хранит данные для поиска сериала
    class serialRequest {
        constructor() {
            this.fields = 'id,title,originalTitle,yearStart,yearEnd,tvNetwork,genre,seasonNumber,episodeNumber,poster72';
            this.sort = 'serial.title';
            this.order = 'ASC';
            this.locGenres = [];
            this.locTvNetworks = [];
            this.locYearsStart = [];
            this.locReleaseDates = [];
        }
        get request() {
            let request = {};
            if (this.title) request.title = this.title;
            if (this.fields) request.fields = this.fields;
            if (this.sort) request.sort = this.sort;
            if (this.order) request.order = this.order;
            if (this.tracks) request.track = this.tracks;
            if (this.genres && 0 != this.genres.length) request.genre = this.genres.join(',');
            if (this.tvNetworks && 0 != this.tvNetworks.length) request.tvNetwork = this.tvNetworks.join(',');
            if (this.yearsStart && 0 != this.yearsStart.length) request.yearStart = this.yearsStart.join(',');
            if (this.releaseDates && 0 != this.releaseDates.length) request.releaseDate = this.releaseDates.join(',');
            return request;
        }
        set genres(newGenre) {
            this.locGenres.push(newGenre);
        }
        get genres() {
            return this.locGenres;
        }
        genreRemove(genre) {
            let iGenre = this.locGenres.indexOf(genre);
            this.locGenres.splice(iGenre, 1);
        }
        set tvNetworks(newTvNetwork) {
            this.locTvNetworks.push(newTvNetwork);
        }
        get tvNetworks() {
            return this.locTvNetworks;
        }
        tvNetworkRemove(tvNetwork) {
            let iTvNetwork = this.locTvNetworks.indexOf(tvNetwork);
            this.locTvNetworks.splice(iTvNetwork, 1);
        }
        set yearsStart(newYearStart) {
            this.locYearsStart.push(newYearStart);
        }
        get yearsStart() {
            return this.locYearsStart;
        }
        yearStartRemove(yearStart) {
            let iYearStart = this.locYearsStart.indexOf(yearStart);
            this.locYearsStart.splice(iYearStart, 1);
        }
        set releaseDates(newReleaseDate) {
            alert('Не определён');
            return false;
        }
        get releaseDates() {
            return this.locReleaseDates;
        }
        releaseDatesClear() {
            this.locReleaseDates = [];
        }
    }
    let srObject = new serialRequest;
    //события
    $('input.start__title-field').keypress(function(e) {
        if (e.which == 13) {
            searchSerial(srObject.request);
        }
    });
    $('input.start__title-field').on('input', function() {
        srObject.title = this.value;
    });
    $('input[name="order"]').on('change', function() {
        srObject.order = this.value;
        searchSerial(srObject.request);
    });
    $('input[name="sort"]').on('change', function() {
        srObject.sort = this.value;
        searchSerial(srObject.request);
    });
    $('input[name="track"]').on('change', function() {
        if (this.checked) srObject.tracks = '*';
        else delete(srObject.tracks);
        searchSerial(srObject.request);
    });
    $('input[name="genre"]').on('change', function() {
        if (this.checked) srObject.genres = this.value;
        else srObject.genreRemove(this.value);
        searchSerial(srObject.request);
    });
    $('input[name="tvNetwork"]').on('change', function() {
        if (this.checked) srObject.tvNetworks = this.value;
        else srObject.tvNetworkRemove(this.value);
        searchSerial(srObject.request);
    });
    $('input[name="yearStart"]').on('change', function() {
        if (this.checked) srObject.yearsStart = this.value;
        else srObject.yearStartRemove(this.value);
        searchSerial(srObject.request);
    });
    searchSerial(srObject.request);

    function printNotFound() {
        let notFound = $('<div>').addClass('start__not-found col-12').text('Такого нет :(');
        $('.main__serial-list').append(notFound);
    }

    function clearSerialList() {
        $('.main__serial-list').html('');
    }

    function searchSerial(requestData) {
        let request = $.ajax({
            method: 'GET',
            url: 'http://localhost:8000/api/serial/search',
            data: requestData
        });
        request.done(function(response) {
            clearSerialList();
            let serials = response.response;
            serials.forEach(function(serial) {
                printSerial(serial);
            });
        });
        request.fail(function(jqXHR) {
            clearSerialList();
            printNotFound();
        });
    }

    function printSerial(serial) {
        let div = $('<div>').addClass('serial-item col-12 col-md-6 col-lg-12 col-xl-6');
        let div_a = $('<a>').addClass('serial-item__wrap').attr({
            href: '/serial/' + serial.id
        });
        if (serial.poster72) {
            div_a.append($('<img>').addClass('serial-item__poster').attr({
                alt: serial.title,
                src: '/bundles/backend/images/' + serial.poster72
            }));
        }
        let div_a_div = $('<div>').addClass('serial-item__content').append($('<span>').addClass('serial-item__title text_one-line').append(serial.title));
        let div_a_div_div1 = $('<div>').addClass('serial-item__detail text_one-line').append($('<span>').addClass('serial-item__original-title').append(serial.originalTitle));
        let div_a_div_div_span = $('<span>').addClass('serial-item__date').append('(');
        if (serial.yearStart) div_a_div_div_span.append(serial.yearStart);
        else div_a_div_div_span.append('…');
        div_a_div_div_span.append(' – ');
        if (serial.yearEnd) div_a_div_div_span.append(serial.yearEnd);
        else div_a_div_div_span.append('…');
        div_a_div_div_span.append(')');
        let div_a_div_div_div = $('<div>').addClass('serial-item__genre text_one-line');
        if (serial.genre) {
            div_a_div_div_div.append((serial.genre.map(function(elem) {
                return elem.title;
            })).join(', '));
        }
        let div_a_div_div2 = $('<div>').addClass('serial-item__data');
        let div_a_div_div2_span = $('<span>').addClass('serial-item__badge badge badge-default');
        if (serial.tvNetwork) div_a_div_div2_span.append(serial.tvNetwork.title);
        let div_a_div_div2_div = $('<div>').addClass('serial-item__release-detail');
        let div_a_div_div2_div_span = $('<span>').addClass('serial-item__quantity');
        div_a_div_div2_div_span.append(' сезонов: ')
        if (serial.seasonNumber) div_a_div_div2_div_span.append(serial.seasonNumber)
        else div_a_div_div2_div_span.append(0);
        div_a_div_div2_div_span.append(', эпизодов: ');
        if (serial.episodeNumber) div_a_div_div2_div_span.append(serial.episodeNumber);
        else div_a_div_div2_div_span.append(0);
        div_a_div_div1.append(div_a_div_div_span);
        div_a_div_div1.append(div_a_div_div_div);
        div_a_div.append(div_a_div_div1);
        div_a_div_div2.append(div_a_div_div2_span);
        div_a_div_div2_div.append(div_a_div_div2_div_span);
        div_a_div_div2.append(div_a_div_div2_div);
        div_a_div.append(div_a_div_div2);
        div_a.append(div_a_div);
        div.append(div_a);
        $('.main__serial-list').append(div);
    }
    //визуал страницы
    $(".tab__period").datepicker({
        showOtherMonths: true,
        onSelect: function(dateText, inst) {
            $('.tab__header_cancel[data-cancel="period"]').css('opacity', 1);
            if ($(this).attr('data-period') == 'start') srObject.locReleaseDates[0] = dateText;
            else srObject.locReleaseDates[1] = dateText;
            searchSerial(srObject.request);
        }
    });
    $('.tab__header_cancel[data-cancel="period"]').on('click', function() {
        $(this).css('opacity', 0);
        $('.tab__period').val('');
        srObject.releaseDatesClear();
        searchSerial(srObject.request);
    });
    $('.tab__header').accordion();
    $('input[name="sort"]:first').prop('checked', true);
    $('input[name="order"]:first').prop('checked', true);
});