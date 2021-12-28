function shuffle(array) {

    var currentIndex = array.length,
        temporaryValue, randomIndex;




    while (0 !== currentIndex) {




        randomIndex = Math.floor(Math.random() * currentIndex);

        currentIndex -= 1;




        temporaryValue = array[currentIndex];

        array[currentIndex] = array[randomIndex];

        array[randomIndex] = temporaryValue;

    }



    return array;

}



var neededFiles;

var downloadedFiles = 0;



function DownloadingFile(fileName) {

    downloadedFiles++;

    refreshProgress();



    setStatus("Téléchargement des addons, etc...");

}



function SetStatusChanged(status) {

    if (status.indexOf("Téléchargement de : #") != -1) {

        downloadedFiles++;

        refreshProgress();
        // Modifiez le nom de votre serveur :
    } else if (status == "Envoie des informations") {

        setProgress(100);

    }



    setStatus(status);

}



function SetFilesNeeded(needed) {

    neededFiles = needed + 1;

}



function refreshProgress() {

    progress = Math.floor(((downloadedFiles / neededFiles) * 100));



    setProgress(progress);

}



function setStatus(text) {

    $("#status").html(text);

}



function setProgress(progress) {

    $("#loading-progress").css("width", progress + "%");

}



function setMusicName(name) {

    $("#music-name").fadeOut(2000, function() {

        $(this).html(name);

        $(this).fadeIn(2000);

    });

}



var youtubePlayer;

var actualMusic = -1;



$(function() {


    if (l_musicRandom)

        l_musicPlaylist = shuffle(l_musicPlaylist);



    if (l_music) {

        loadYoutube();

        if (l_musicDisplay)

            $("#music").fadeIn(2000);

    }

});



function loadYoutube() {

    var tag = document.createElement('script');



    tag.src = "https://www.youtube.com/iframe_api";

    var firstScriptTag = document.getElementsByTagName('script')[0];

    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

}



function onYouTubeIframeAPIReady() {

    youtubePlayer = new YT.Player('player', {

        height: '390',

        width: '640',

        events: {

            'onReady': onPlayerReady,

            'onStateChange': onPlayerStateChange

        }

    });

}



function onPlayerReady(event) {

    youtubePlayer.setVolume(l_musicVolume);

    if (youtubePlayer.isMuted()) youtubePlayer.unMute();

    nextMusic();

}



function onPlayerStateChange(event) {

    if (event.data == YT.PlayerState.ENDED) {

        nextMusic();

    }

}



function nextMusic() {

    actualMusic++;



    if (actualMusic >= l_musicPlaylist.length) {

        actualMusic = 0;

    }



    var atual = l_musicPlaylist[actualMusic];



    if (atual.youtube) {

        youtubePlayer.loadVideoById(atual.youtube);

    } else {

        $("body").append('<audio src="' + atual.ogg + '" autoplay>');

        $("audio").prop('volume', l_musicVolume / 100);

        $("audio").bind("ended", function() {

            $(this).remove();

            nextMusic();

        });

    }



    setMusicName(atual.name);

}