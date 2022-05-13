// import $ from 'jquery';
//  import slick from 'slick-carousel';

//  import GoogleMap from './modules/GoogleMap';
//  import MobileMenu from './modules/MobileMenu';
//  import HeroSlider from './modules/HeroSlider';

//   //var googleMap = new GoogleMap();
//    var mobileMenu = new MobileMenu();
//    var heroSlider = new HeroSlider();

      // var search = new Search();



/* Search.js */
//  let openButton = document.querySelector('.js-search-trigger');
//  let closeButton = document.querySelector('.search-overlay__close');
// let searchOverlay = document.querySelector('.search-overlay');


var $ = jQuery.noConflict();

    class Search{
        // 1. Describe And create/initiate Our Object
    
        constructor(){
            this.addSearchHTML();
            this.resulstDiv = $("#search-overlay__results")
            this.openButton = $(".js-search-trigger");
            this.closeButton = $(".search-overlay__close");
            this.searchOverlay = $(".search-overlay"); 
            this.searchField =  $('#search-term');
            this.events();
            this.isOverlayopen = false;
            this.isSpinnerVisible = false;
            this.previousValue;
            this.typingTimer;
        }
        // 2. All Events
        events(){
            this.openButton.on("click", this.openOverlay.bind(this));
            this.closeButton.on("click", this.closeOverlay.bind(this));
            $(document).on("keydown", this.keyPressDispatcher.bind(this));
            // this.searchField.on("keyup", this.typingLogic.bind(this));
            this.searchField.on("keydown", this.typingLogic.bind(this));
        }
        // 3. Methods (functions,actions)
        // typingLogic(){
        //     clearTimeout(this.typingTimer);
        //     this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
        // }
        // getResults(){
        //     this.resulstDiv.html("Imagine Real search results here");
        // }

        typingLogic(){
            if(this.searchField.val() != this.previousValue){
                clearTimeout(this.typingTimer);
                if(this.searchField.val()){
                    if(!this.isSpinnerVisible){
                        this.resulstDiv.html('<div class="spinner-loader"></div>');
                        this.isSpinnerVisible = true;
                    }
                    this.typingTimer = setTimeout(this.getResults.bind(this),800);
                }else{
                    this.resulstDiv.html('');
                    this.isSpinnerVisible = false;
                }

               
            }
            
            this.previousValue = this.searchField.val();
        }
        // 

        getResults(){
            $.getJSON(universityData.root_url + '/wp-json/university/v1/search?term=' + this.searchField.val(),(results) => {
                this.resulstDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                            ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No General Information Matches This Search</p>'}
                            ${results.generalInfo.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == 'post' ? `by ${item.authorName}`: '' }</li>`).join('')}
                            ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                            ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No Programs Match That Search. <a href="${universityData.root_url}/programs">View All Programs</a></p>`}
                            ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                            ${results.programs.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Professors</h2>
                            ${results.professors.length ? '<ul class="professor-cards">' : `<p>No professors Matches This Search.`}
                            ${results.professors.map(item => `
                            <li class="professor-card__list-item">
                            <a class="professor-card" href="${item.permalink}">
                            <img class="professor-card__image" src="${item.image}" alt="">
                            <span class="professor-card__name">${item.title}</span>
                            </a>
                          </li>`).join('')}
                            ${results.professors.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                            ${results.campuses.length ? '<ul class="link-list min-list">' : `<p>No Campuses Match That Search. <a href="${universityData.root_url}/campuses">View All Campuses</a></p>`}
                            ${results.campuses.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                            ${results.campuses.length ? '</ul>' : ''}
                        <h2 class="search-overlay__section-title">Events</h2>
                            ${results.events.length ? '' : `<p>No Events Match That Search. <a href="${universityData.root_url}/events">View All Events</a></p>`}
                            ${results.events.map(item => `        <div class="event-summary">
                            <a class="event-summary__date t-center" href="${item.permalink}">
                              <span class="event-summary__month"> ${item.month}</span>
                              <span class="event-summary__day"> ${item.day}</span>  
                            </a>
                            <div class="event-summary__content">
                              <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                              <p>${item.description}<a href="${item.permalink}" class="nu gray">Learn more</a></p>
                            </div>
                          </div>`).join('')}

                    </div>
                </div>
                `);
                this.isSpinnerVisible = false;
             });//if(has_excerpt()){
            //     echo get_the_excerpt();
            //   }else{
            //     echo wp_trim_words(get_the_content(),18);
            //   }
            
        }
// OLD CODE
            // $.when(
            //     $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchField.val()),
            //     $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchField.val())
            //     ).then((posts, pages) => {
            //     var combinedResults = posts[0].concat(pages[0]);
            //     this.resulstDiv.html(`
            //     <h2 class="search-overlay__section-title">General Informtaion</h2>
            //     ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No General Information Matches This Search</p>'}
            //     ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a> ${item.type == 'post' ? `by ${item.authorName}`: '' }</li>`).join('')}
            //     ${combinedResults.length ? '</ul>' : ''}
            //     `);
            //     this.isSpinnerVisible = false;
            // },() => {
            //     this.resulstDiv.html('<p>Unexpected Error</p>');
            // }); 
        keyPressDispatcher(e){
            if(e.keyCode == 83 && !this.isOverlayopen && !$("input , textarea").is(':focus')){
                this.openOverlay();
            }
            if(e.keyCode == 27  && this.isOverlayopen){
                this.closeOverlay();
            }
        }
        openOverlay(){
            this.searchOverlay.addClass("search-overlay--active");
            $("body").addClass("body-no-scroll");
            this.searchField.val('');
            setTimeout(() => this.searchField.focus() ,400);
            console.log("Our Open method just ran");
            this.isOverlayopen = true;
            return false;

        }
        closeOverlay(){
            this.searchOverlay.removeClass("search-overlay--active");
            $("body").removeClass("body-no-scroll");
            console.log("Our Close method just ran");
            this.isOverlayopen = false;
        } 
        // search-overlay--active
        addSearchHTML(){
            $("body").append(`
            

            <div class="search-overlay ">
              <div class="search-overlay__top">
                <div class="container">
                  <i class="fas fa-search search-overlay__icon" aria-hidden="true"></i>
                  <input type="text" name="" id="search-term" class="search-term" placeholder="What are you looking for?">
                  <i class="fas fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
              </div>
              <div class="container">
                <div id="search-overlay__results">
                  
                </div>
              </div>
            </div>
            `);
        }
    }
    
     var search = new Search();


// //  let openButton = document.querySelector('.js-search-trigger');
// //  let closeButton = document.querySelector('.search-overlay__close');
// // let searchOverlay = document.querySelector('.search-overlay');


// // openButton.onclick =() =>{
// // 	searchOverlay.classList.add('.search-overlay--active');
// // }

// // closeButton.onclick =() =>{
// // 	searchOverlay.classList.remove('.search-overlay--active');
// // }


// // var $ = jQuery.noConflict();

// //     class Search{
// //         // 1. Describe And create/initiate Our Object
    
// //         constructor(){
// //             this.openButton = jQuery(".js-search-trigger");
// //             this.closeButton = jQuery(".search-overlay__close");
// //             this.searchOverlay = jQuery(".search-overlay"); 
// //             this.events();
// //         }
// //         // 2. All Events
// //         events(){
// //             this.openButton.on("click", this.openOverlay.bind(this));
// //             this.closeButton.on("click", this.closeOverlay.bind(this));
// //             jQuery(document).on("keyUp", this.keyPressDispatcher.bind(this));
// //         }
// //         // 3. Methods (functions,actions)
// //         keyPressDispatcher(){
// //             console.log("this is a test");
// //         }
// //         openOverlay(){
// //             this.searchOverlay.addClass(".search-overlay--active");
// //             jQuery("body").addClass("body-no-scroll");
// //         }
// //         closeOverlay(){
// //             this.searchOverlay.removeClass(".search-overlay--active");
// //             jQuery("body").removeClass("body-no-scroll");
// //         }
// //     }


//////////////////////////        My_notes             //////////
/////////////////////////////////////////////////////////////////
//////////////////////////////////      My_notes        /////////
////////////////////     My_notes     ///////////////////////////
///////////////////////////////////////          My_notes  //////

class MyNotes{
    constructor(){
        // this.deleteButton = $(".delete-note");
        this.events();
    }

    events(){
        $("#my-notes").on("click", ".delete-note",this.deleteNote);
        $("#my-notes").on("click", ".edit-note",this.editNote.bind(this));
        $("#my-notes").on("click", ".update-note",this.updateNote.bind(this));
        $(".submit-note").on("click", this.createNote);
    }

    // Custom methods
    editNote(e){
        var thisNote = $(e.target).parents("li");
        if(thisNote.data("state") == 'editable'){
            this.makeNoteReadOnly(thisNote);
        }else{
            this.makeNoteEditable(thisNote);
        }
        
    }
    makeNoteEditable(thisNote){
        thisNote.find(".edit-note").html('<i class="fas fa-times" aria-hidden="true"></i> Cancel');
        thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-field-active");
        thisNote.find(".update-note").addClass("update-note--visible");
        thisNote.data("state", "editable");
    }
    makeNoteReadOnly(thisNote){
        thisNote.find(".edit-note").html('<i class="fas fa-pencil" aria-hidden="true"></i> Edit');
        thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-field-active");
        thisNote.find(".update-note").removeClass("update-note--visible");
        thisNote.data("state", "cancel");

    }
    deleteNote(e){
        var thisNote = $(e.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (response) => {
               thisNote.slideUp();
               console.log("You Deleted It.");
               console.log(response);
               if(response.userNote < 5){
                    $(".note-limit-message").addClass("note-limit-message");
                }

            },
            error: (response) => {
                console.log("It Failed");
                console.log(response);
            },

        });
    }

    updateNote(e){
        var thisNote = $(e.target).parents("li");
        var ourUpdatedPost = {
            'title': thisNote.find(".note-title-field").val(),
            'content': thisNote.find(".note-body-field").val()
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'POST',
            data: ourUpdatedPost,
            success: (response) => {
                this.makeNoteReadOnly(thisNote);
                console.log("You Updated It.");
                console.log(response);

            },
            error: (response) => {
                console.log("It Failed");
                console.log(response);
            },

        });
    }

    createNote(e){
        var ourNewPost = {
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'publish'
        }
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/wp/v2/note/',
            type: 'POST',
            data: ourNewPost,
            success: (response) => {
                $(".new-note-title, .new-note-body").val('');
                $(`
                <li data-id="${response.id}">
                  <input readonly class="note-title-field" value="${response.title.raw}">
                  <span class="edit-note"><i class="fas fa-pencil" aria-hidden="true"></i>Edit</span>
                  <span class="delete-note"><i class="fas fa-trash-o" aria-hidden="true"></i>Delete</span>
                  <textarea readonly class="note-body-field" name="" id="" cols="30" rows="10">${response.content.raw}</textarea>
                  <span class="update-note btn btn--blue btn--small"><i class="fas fa-arrow-right" aria-hidden="true">Save</i></span>

              </li>
                `).prependTo('#my-notes').hide().slideDown();
                console.log("You Created it.");
                console.log(response);
                
            },
            error: (response) => {
                if(response.responseText == "You Have Reached Your Note Limit."){
                    $(".note-limit-message").addClass("note-limit-message-visible");
                }
                console.log("It Failed");
                console.log(response);
            },

        });
    }

    
}
 var mynotes = new MyNotes();

 //////////////////////////        LIKES.js             //////////
/////////////////////////////////////////////////////////////////
//////////////////////////////////      LIKES.js         /////////
////////////////////     LIKES.js      ///////////////////////////
///////////////////////////////////////          LIKES.js   //////

class Like{
    constructor(){
        this.events();
    }
    // 2. Events Here
    events(){
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }
    // 3. custom methods here 
    ourClickDispatcher(e){
        var currentLikeBox = $(e.target).closest('.like-box');
        if(currentLikeBox.attr('data-exists') == 'yes'){
            this.deleteLike(currentLikeBox);
        }else{
            this.createLike(currentLikeBox);
        }
    }
    createLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            data:{
                'professorId': currentLikeBox.data('professor')
            },
            success: (response) => {
                console.log(response);
                currentLikeBox.attr('data-exists', 'yes');
                var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
                likeCount++;
                currentLikeBox.find('.like-count').html(likeCount);
                currentLikeBox.attr('data-like',response);

            },
            error: (response) => {
                console.log(response);
            },
        });
    }
    deleteLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            data:{
                'like': currentLikeBox.attr('data-like')
            },
            type: 'DELETE',
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no');
                var likeCount = parseInt(currentLikeBox.find('.like-count').html(), 10);
                likeCount--;
                currentLikeBox.find('.like-count').html(likeCount);
                currentLikeBox.attr('data-like','');
                console.log(response);
            },
            error: (response) => {
                console.log("You gotta scratch your haed more");
            },
        });
    }
}
var like = new Like();
