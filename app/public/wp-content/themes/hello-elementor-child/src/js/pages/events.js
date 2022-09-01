function setQueryStringParameter(values) {
    const params = new URLSearchParams();

    values.map(v =>  params.append('categories', v));

    const paramString = params.toString() ? `?${params}`: '';
    window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${paramString}`));
}

function getQueryStringCategories() {
    return new URLSearchParams(window.location.search).getAll('categories');
}
const eventpage = {
    init: function () {
        this.eventFilter();
        this.tagClick();
    },
    eventFilter: function () {
        let request_data, keyword;
        let $filter_items = $('.filter-button-new');
        let $event_container = $('.events-list .row');
        let $search = $('.search-bar form');
        let filterTagContainer = document.querySelector(".filter-tag-container");
        let tagToClone = document.querySelector(".tag-hidden");
        let loader = document.querySelector('.loader');
        let tagsArray = [];    
        if(getQueryStringCategories().length) {
            getQueryStringCategories().forEach(id => {
                let checkbox = document.querySelector(`input#${id}`);

                if(checkbox) {
                let text = checkbox.parentElement.nextElementSibling;
                text.style.color = "#F06149";
                checkbox.checked = true;
                }
            });

            $event_container.empty();
            loader.classList.add('loaderActive');
            load_event();
        }
        function load_event() {
            var selected = new Array();
            $("input[type=checkbox]:checked").each(function () {
                selected.push(this.value);
            });
            keyword = $('.search-bar').find('input').val();

            const categories = Array.from(
                document.querySelectorAll('input[type="checkbox"]:checked')
            ).map((item) => {
               
                return item.value;
            });
            setQueryStringParameter(categories);
            filterTag();
            if (categories.length === 0 && tagsArray.length === 0) {
                posts_per_page = 6;
                paged = 1;
            }

            request_data = {
                action: 'load_event',
                eventCat: selected,
                tags: tagsArray,
                keyword: keyword,
            };
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: request_data,
                success: function (response_data) {
                    loader.classList.remove('loaderActive')
                    response_ccccc = $(response_data).find('.row').html();
                    if (response_data.length) {
                        $event_container.html(response_ccccc);
                        MatchHeight();
                    } else {
                        $event_container.html('<h2 class="col-lg-12 no-result">There were no Events found.</h2>');
                    }

                    setTimeout(() => {
                        document.querySelectorAll(".tags-container .tag").forEach((tag) => {
                            tag.removeEventListener("click", queryTag);
                            tag.addEventListener("click", queryTag);
                        });
                    }, 200);

                }
            });

        }

        function MatchHeight() {
            $('.page-template-events .card .text-wrap h3').matchHeight();
            $('.page-template-events .card .text-wrap .excerpt').matchHeight();
            $('.page-template-events .card .text-wrap .date-location').matchHeight();
        }
        MatchHeight();
        // Filter Event
        $filter_items.on('click', function (e) {
            e.preventDefault();

            $event_container.empty();
            loader.classList.add('loaderActive');
            load_event();
            $filter_items.parent().removeClass('show');
        });

        $search.on('submit', function (e) {
            e.preventDefault();
            $event_container.empty();
            loader.classList.add('loaderActive');
            load_event(); 
        });


        document.querySelectorAll('input[type="checkbox"]').forEach((item) => {
            item.addEventListener("click", function (e) {
                let checked = e.currentTarget.checked;
                let text = e.currentTarget.parentElement.nextElementSibling;

                checked
                    ? (text.style.color = "#F06149")
                    : (text.style.color = "#414245");
            });
        });

        document
            .querySelector(".dropdown-menu")
            .addEventListener("click", function (e) {
                e.stopPropagation();
                // Stops drop down from closing when click inside
            });


        $('.cat-tags a').on('click', function (e) {
            e.preventDefault();
            console.log('aaaa');
            return false;
        });


        // TAGS FILTER

        document.querySelectorAll(".tags-container .tag").forEach((tag) => {
            tag.addEventListener("click", queryTag);
        });

        function queryTag(e) {
            let item = e.currentTarget;
            let tag = item.dataset.id;
            let name = item.dataset.name;

            if (!tagsArray.includes((tag))) {
                // let newTag = tagToClone.cloneNode(true);
                // $event_container.empty();
                // filterTagContainer.style.display = "flex";
                // newTag.classList.remove("tag-hidden");
                // newTag.querySelector(".tag-text").innerHTML = name;
                // newTag.dataset.id = tag;
                // newTag.addEventListener("click", removeTag);
                // tagsArray.push((tag));
                // filterTagContainer.appendChild(newTag);

                // let tagFilter = tagsArray;
                // //    history.pushState("tag", "=", tagFilter);
                // console.log(tagFilter);

                let checkbox = document.querySelector(`input#${tag}`);

                if(checkbox) {
                    let text = checkbox.parentElement.nextElementSibling;
                    text.style.color = "#F06149";
                    checkbox.checked = true;
                }

                $event_container.empty();
                loader.classList.add('loaderActive');
                load_event();
            }
        }

        function filterTag() {
            const catd = document.querySelectorAll('input[type="checkbox"]:checked');
            console.log(catd);

            const existing = document.querySelectorAll('.tag-filter');
            existing.forEach(item => {
                item.classList.add('tag-hidden');
            });

            catd.forEach(item => {
                const exists = document.querySelector(`#${item.value}-tag`);
                if (!exists) {
                    let newTag = tagToClone.cloneNode(true);
                    newTag.id = `${item.value}-tag`;
                    newTag.dataset.name = item.dataset.name;
                    newTag.dataset.id = item.value;
                    filterTagContainer.style.display = "flex";
                    newTag.dataset.value = item.value;
                    newTag.classList.add("tag-filter");
                    newTag.classList.remove("tag-hidden");
                    newTag.querySelector(".tag-text").innerHTML = item.dataset.name;
                    filterTagContainer.appendChild(newTag);
                    newTag.addEventListener("click", removeFilterTag);
                } else {
                    exists.classList.remove("tag-hidden");
                }
            });

        }
        function removeFilterTag(e) {
            console.log('removeFilterTag');
            let item = e.currentTarget;
            let tag = item.id;
            let id = item.dataset.id;

            let checkbox = document.querySelector(`input#${id}`);

            if (checkbox) {
                let text = checkbox.parentElement.nextElementSibling;
                text.style.color = "#414245";
                checkbox.checked = false;
                item.remove();
                $event_container.empty();
                loader.classList.add('loaderActive');
                load_event();
            }

        }
        function removeTag(e) {
            console.log('removeTag');
            let item = e.currentTarget;
            let tag = item.dataset.id;

            if (tagsArray.includes((tag))) {
                tagsArray.splice(tagsArray.indexOf((tag)), 1);

                if (tagsArray.length === 0) {
                    filterTagContainer.style.display = "none";

                }

                item.remove();

                $event_container.empty();
                loader.classList.add('loaderActive');
                load_event();
            }
        }
// TAGS FILTER

        return false;


    },
    tagClick: function() {

        function addEvent() {
            document.querySelectorAll('.tag').forEach(tag => tag.addEventListener('click', goToTop));
            function goToTop() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
  
        const targetNode = document.querySelector('.listing-section');
  
        // Options for the observer (which mutations to observe)
        const config = { attributes: true, childList: true, subtree: true };
        
        // Callback function to execute when mutations are observed
        const callback = (mutationList, observer) => {
          for (const mutation of mutationList) {
            if (mutation.type === 'childList') {
              addEvent()
            }
          }
        };
        
        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);
        
        // Start observing the target node for configured mutations
        observer.observe(targetNode, config);
  
        addEvent()
    }


};

(function ($) {
    eventpage.init();
})(jQuery);
