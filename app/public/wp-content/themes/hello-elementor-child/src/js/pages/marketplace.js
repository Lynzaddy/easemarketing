function setQueryStringParameter(values, tags) {
    // benefit types and partner types have been condensed into one category called categories. When you click a tag or use the drop down it will append to categories.

    const params = new URLSearchParams();

    values.map(v =>  params.append('categories', v));
    // tags.map(v => params.append('tags',v.tag));

    const paramString = params.toString() ? `?${params}`: '';
    window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${paramString}`));
}

// function setQueryTagStringParameter(value) {
//     const params = new URLSearchParams();
//     params.append('tags', value)
//     const paramString = params.toString() ? `?${params}`: '';
//     window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${paramString}`));
// }

function getQueryStringCategories() {
    return new URLSearchParams(window.location.search).getAll('categories');
}

function getQueryStringTags() {
    return new URLSearchParams(window.location.search).getAll('tags');
}

const marketplacepage = {
    init: function () {
        this.marketplaceFilter();
        this.tagClick();
    },
    marketplaceFilter: function () {
        let request_data, keyword;
        let $filter_items = $('.filter-button-new');
        let $marketplace_container = $('.marketplace-list .row');
        let $search = $('.search-bar form');
        let filterTagContainer = document.querySelector(".filter-tag-container");
        let tagToClone = document.querySelector(".tag-hidden");
        let loader = document.querySelector('.loader');
        let tagsArray = []; 
               
        if(getQueryStringCategories().length || getQueryStringTags().length) {
            
            getQueryStringCategories().forEach(id => {
                let checkbox = document.querySelector(`input#${id}`);

                if(checkbox) {
                    tagsArray.push({tag: id, taxonomy: 'partner_types'}); 
                    let text = checkbox.parentElement.nextElementSibling;
                    text.style.color = "#F06149";
                    checkbox.checked = true;
                }
            });

            // getQueryStringTags().forEach(tag => {
            //     let checkbox = document.querySelector(`input#${tag}`);
            //     let text = checkbox.parentElement.nextElementSibling;
            //     text.style.color = "#F06149";
            //     checkbox.checked = true;

            //     // let newTag = tagToClone.cloneNode(true);
            //     // filterTagContainer.style.display = "flex";
            //     // newTag.classList.remove("tag-hidden");
            //     // newTag.querySelector(".tag-text").innerHTML = jQuery(`[data-id="${tag}"]`).first().data('name');
            //     // newTag.dataset.id = tag;
            //     // newTag.addEventListener("click", removeTag);
            //     tagsArray.push({tag: tag, taxonomy: 'partner_types'});
            
            //     // filterTagContainer.appendChild(newTag);
            // });
            // getQueryTagStringCategories().forEach(id => {
            //     let checkbox = document.querySelector(`input#${id}`);

            //     if(checkbox) {
            //     tagsArray.push({tag: id, taxonomy: 'partner_types'});
            //     let text = checkbox.parentElement.nextElementSibling;
            //     text.style.color = "#F06149";
            //     checkbox.checked = true;
            //     }
            // });
  


            $marketplace_container.empty();
            loader.classList.add('loaderActive');
            load_marketplace();
        }
        function load_marketplace() {
            // var selected = new Array();
            // $("input[type=checkbox]:checked").each(function () {
                
            //     tagsArray.push({tag: this.value, taxonomy: 'partner_types'});
            //     // selected.push(this.value);
            // });

            // console.log(tagsArray)

            keyword = $('.search-bar').find('input').val();

            const categories = Array.from(
                document.querySelectorAll('input[type="checkbox"]:checked')
            ).map((item) => item.value);
            setQueryStringParameter(categories, tagsArray);
            filterTag();
            if (categories.length === 0 && tagsArray.length === 0) {
                posts_per_page = 6;
                paged = 1;
            }

            request_data = {
                action: 'load_marketplace',
                // marketplaceCat: selected,
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
                        $marketplace_container.html(response_ccccc);
                        MatchHeight();
                    } else {
                        $marketplace_container.html('<h2 class="col-lg-12 no-result">Whoops! No partner matches your search.</h2>');
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
            $('.page-template-marketplace .card .text-wrap h3').matchHeight();
            $('.page-template-marketplace .card .text-wrap .excerpt').matchHeight();
        }
        MatchHeight();

        // Filter Event
        $filter_items.on('click', function (e) {
            e.preventDefault();
            $marketplace_container.empty();
            loader.classList.add('loaderActive');
            load_marketplace();
        });

        $search.on('submit', function (e) {
            e.preventDefault();
            $marketplace_container.empty();
            loader.classList.add('loaderActive');
            load_marketplace();
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


        // TAGS FILTER

        document.querySelectorAll(".tags-container .tag").forEach((tag) => {
            tag.addEventListener("click", queryTag);
        });

        document.querySelectorAll(".checkbox-container input").forEach((checkbox) => {
            checkbox.addEventListener('click', addToFilterArray)
        });

        function addToFilterArray(e) {

            let checked = e.target.checked;
            let value = e.target.value;

            if (checked) {
                tagsArray.push({tag: value, taxonomy: 'partner_types'});
            } else {
                const index = tagsArray.findIndex(object => {
                    return object.tag === value;
                });

                if (index !== -1) {
                    tagsArray.splice(index, 1);
                }
            }
        }

        function queryTag(e) {
            let item = e.currentTarget;
            let tag = item.dataset.id;
            let name = item.dataset.name;
            let taxonomy = item.dataset.taxonomy;
            
            if (!tagsArray.some(e => e.tag === tag)) {
                $marketplace_container.empty();


                // let newTag = tagToClone.cloneNode(true);
                // filterTagContainer.style.display = "flex";
                // newTag.classList.remove("tag-hidden"); 
                // newTag.querySelector(".tag-text").innerHTML = name;
                // newTag.dataset.id = tag;
                // newTag.addEventListener("click", removeTag);

                let checkbox = document.querySelector(`input#${tag}`);

                if(checkbox) {
                    let text = checkbox.parentElement.nextElementSibling;
                    text.style.color = "#F06149";
                    checkbox.checked = true;
                }

                tagsArray.push({tag: tag, taxonomy: taxonomy});

                // filterTagContainer.appendChild(newTag);

                // setQueryTagStringParameter(tag);
                
                // let tagFilter = tagsArray;
            //    history.pushState("tag", "=", tagFilter);
                loader.classList.add('loaderActive');
                load_marketplace();
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
            // let tag = item.id;
            let id = item.dataset.id; // This is the tag

            let checkbox = document.querySelector(`input#${id}`);

            if (tagsArray.some(e => e.tag === id)) {

                const index = tagsArray.findIndex(object => {
                  return object.tag === id;
                });

                tagsArray.splice(index, 1);

                if (tagsArray.length === 0) {
                    filterTagContainer.style.display = "none";
                }
            }

            if (checkbox) {
                let text = checkbox.parentElement.nextElementSibling;
                text.style.color = "#414245";
                checkbox.checked = false;
                item.remove();
                $marketplace_container.empty();
                loader.classList.add('loaderActive');
                load_marketplace();
            }
        }
        
        function removeTag(e) {
            console.log('removeTag');
            let item = e.currentTarget;
            let tag = item.dataset.id;

            if (tagsArray.some(e => e.tag === tag)) {

                const index = tagsArray.findIndex(object => {
                  return object.tag === tag;
                });

                tagsArray.splice(index, 1);

                if (tagsArray.length === 0) {
                    filterTagContainer.style.display = "none";
                }

                item.remove();
                $marketplace_container.empty();
                loader.classList.add('loaderActive');
                load_marketplace();
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
    marketplacepage.init();
})(jQuery);
