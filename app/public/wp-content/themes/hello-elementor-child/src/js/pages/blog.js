function setQueryStringParameter(values, tags) {
  
  const params = new URLSearchParams();
 
  values.map(v =>  params.append('categories', v));
  tags.map(v => params.append('tags',v));
  const paramString = params.toString() ? `?${params}`: '';
  window.history.replaceState({}, "", decodeURIComponent(`${window.location.pathname}${paramString}`));
}

function getQueryStringCategories() {
  return new URLSearchParams(window.location.search).getAll('categories');
}
function getQueryStringTags() {
  return new URLSearchParams(window.location.search).getAll('tags');
}
(function ($) {
  const blogpage = {
    init: function () {
      this.blogFilter();
      this.blogLoad();
      this.callAJAX();
      this.tagClick();
    },
    callAJAX: function (request_data) {
      if (!request_data) return;
      return new Promise((resolve, reject) => {
        $.ajax({
          url: ajaxurl,
          type: "post",
          data: request_data,
          cache: false,
          async: true,
          success: function (response_data) {
            resolve(response_data);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            reject(thrownError)
          }
        });
      })
    },
    blogLoad: function() {
      let blogLink = document.querySelector("[href*='/blog']");

      if(blogLink) {
        blogLink.classList.add('active')
      }
    },
    blogFilter: function () {
      let request_data, blogCategory, keyword, paged, posts_per_page;
      let $filter_items = $(".filter-dropdown .dropdown-item").not(
        ".reset-button"
      );
      let $reset_button = $(".reset-button");
      let $marketplace_container = $(".card-container");
      let $search = $(".search-bar form");
      let filterDropDown = document.querySelector(".dropdown-toggle");
      const featuredPostContainer = document.querySelector('.featured-post-container');
      const resetFilterContainer = document.querySelector('.reset-filter-container');
      let filterButton = document.querySelector(".filter-button-new");
      let filterTagContainer = document.querySelector(".filter-tag-container");
      let tagToClone = document.querySelector(".tag-hidden");
      let loader = document.querySelector('.loader');
      let tagsArray = [];

      if(getQueryStringCategories().length || getQueryStringTags().length) {
        getQueryStringCategories().forEach(id => {
          let checkbox = document.querySelector(`input#${id}`);

          if(checkbox) {
            let text = checkbox.parentElement.nextElementSibling;
            text.style.color = "#F06149";
            checkbox.checked = true;
          }
        });
        getQueryStringTags().forEach(tag => {
          let newTag = tagToClone.cloneNode(true);
          $marketplace_container.empty();
          filterTagContainer.style.display = "flex";
          newTag.classList.remove("tag-hidden");
          newTag.querySelector(".tag-text").innerHTML = jQuery(`[data-id="${tag}"]`).first().data('name');
          newTag.dataset.id = tag;
          newTag.addEventListener("click", removeTag);
          tagsArray.push((tag));
   
          filterTagContainer.appendChild(newTag);
        });
        load_blogs();
      }
      document.querySelectorAll(".tags-container .tag").forEach((tag) => {
        tag.addEventListener("click", queryTag);
      });

      function queryTag(e) {
        let item = e.currentTarget;
        let tag = item.dataset.id;
        let name = item.dataset.name;

        if (!tagsArray.includes((tag))) {
          let newTag = tagToClone.cloneNode(true);
          $marketplace_container.empty();
          filterTagContainer.style.display = "flex";
          newTag.classList.remove("tag-hidden");
          newTag.querySelector(".tag-text").innerHTML = name;
          newTag.dataset.id = tag;
          newTag.addEventListener("click", removeTag);
          tagsArray.push((tag));
   
          filterTagContainer.appendChild(newTag);
          loader.classList.add('loaderActive');
          load_blogs();
        }
      }

      function queryTagOnLoad(e) {
        let item = e.currentTarget;
        let tag = item.dataset.id;
        let name = item.dataset.name;

        if (!tagsArray.includes((tag))) {
          let newTag = tagToClone.cloneNode(true);
          $marketplace_container.empty();
          filterTagContainer.style.display = "flex";
          newTag.classList.remove("tag-hidden");
          newTag.querySelector(".tag-text").innerHTML = name;
          newTag.dataset.id = tag;
          newTag.addEventListener("click", removeTag);
          tagsArray.push((tag));
          filterTagContainer.appendChild(newTag);
          loader.classList.add('loaderActive');
         
        }
      }

      function filterTag() {
        const catd = document.querySelectorAll('input[type="checkbox"]:checked');

        const existing = document.querySelectorAll('.tag-filter');
        existing.forEach(item => {
          item.classList.add('tag-hidden');
        });

        catd.forEach(item => {
          const exists = document.querySelector(`#${item.value}-tag`);
          if(!exists) {
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
        // if (!tagsArray.includes((tag))) {
        //   let newTag = tagToClone.cloneNode(true);
        //   $marketplace_container.empty();
        //   filterTagContainer.style.display = "flex";
        //   newTag.classList.remove("tag-hidden");
        //   newTag.querySelector(".tag-text").innerHTML = tag;
        //   newTag.dataset.id = tag;
        //   //newTag.addEventListener("click", removeTag);
        //   tagsArray.push((tag));
        //   filterTagContainer.appendChild(newTag);
        //   loader.classList.add('loaderActive');
          
        // }
      }
      function removeFilterTag(e) {
        console.log('removeFilterTag');
        let item = e.currentTarget;
        let tag = item.id;
        let id = item.dataset.id;

        let checkbox = document.querySelector(`input#${id}`);

        if(checkbox) {
          let text = checkbox.parentElement.nextElementSibling;
          text.style.color = "#414245";
          checkbox.checked = false;
          item.remove();
          load_blogs();
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
          $marketplace_container.empty();
          loader.classList.add('loaderActive')
          load_blogs();
        }
      }

      function load_blogs() {
        blogCategory = $("#filtermarketplace")
          .find(".dropdown-item.active")
          .attr("href");
        keyword = $(".search-bar").find("input").val();

        const categories = Array.from(
          document.querySelectorAll('input[type="checkbox"]:checked')
        ).map((item) => item.value);
        setQueryStringParameter(categories, tagsArray);
        filterTag();
        if (categories.length === 0 && tagsArray.length === 0) {
          posts_per_page = 6;
          paged = 1;
        }

        if(featuredPostContainer) {
          if(!keyword && !categories.length && !tagsArray.length) {
            featuredPostContainer.classList.remove('hidden');
            resetFilterContainer.classList.add('reset-filter-hide');
          } else {
            featuredPostContainer.classList.add('hidden');
            resetFilterContainer.classList.remove('reset-filter-hide');
          }
        }

        if (resetFilterContainer) {
          if(!keyword && !categories.length && !tagsArray.length) {
            resetFilterContainer.classList.add('reset-filter-hide');
          } else {
            resetFilterContainer.classList.remove('reset-filter-hide');
          }
        }

        request_data = {
          action: "load_blogs",
          categories: categories,
          tags: tagsArray,
          keyword: keyword,
          pg: paged,
          posts_per_page: posts_per_page,
        };

        blogpage
        .callAJAX(request_data)
        .then(response_data => {
          loader.classList.remove('loaderActive')
          if (response_data.length) {
            response_data.replaceAll("wp-admin/admin-ajax.php", "blog");
            response_ccccc = $(response_data).html();
            $marketplace_container.html(response_ccccc);
          } else {
            $marketplace_container.html(
              '<h2 class="no-result">There are no posts matching your filters.</h2>'
            );
          }
          setTimeout(() => {
            document.querySelectorAll(".tags-container .tag").forEach((tag) => {
              tag.removeEventListener("click", queryTag);
              tag.addEventListener("click", queryTag);
            });
          }, 200);
          
        }).catch(err => {
          console.log(err)
        })
      }

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

      //reset
      $reset_button.on("click", function (e) {
        e.preventDefault();
        $marketplace_container.empty();
        posts_per_page = 6;
        paged = 1;
        filterDropDown.innerHTML = "Filter posts";
        filterTagContainer.querySelectorAll('.tag:not(.tag-hidden)').forEach(tag => {
          tag.remove();
        })
        $('.filter-dropdown').find('input[type="checkbox"]:checked').prop('checked', false);
        $('.dropdown-item-new').removeAttr("style");
        $(".search-bar").find("input").val('');
        filterTagContainer.style.display = "none";
        categories = [];
        tagsArray = [];
        loader.classList.add('loaderActive'); 
        load_blogs();
      });

      // Filter Event
      filterButton.addEventListener("click", function (e) {
        e.preventDefault();
        $marketplace_container.empty();
        posts_per_page = -1;
        paged = 1;
        loader.classList.add('loaderActive')
        filterButton.parentElement.classList.remove('show');
        load_blogs();
      });

      $search.on("submit", function (e) {
        e.preventDefault();
        $marketplace_container.empty();
        posts_per_page = -1;
        paged = 1;
        loader.classList.add('loaderActive')
        load_blogs();
      });

      $(".cat-tags a").on("click", function (e) {
        e.preventDefault();
        return false;
      });

      return false;
    },
    tagClick: function() {

      function addEvent() {
          document.querySelectorAll('.tag').forEach(tag => tag.addEventListener('click', goToTop));
          function goToTop() {
              window.scrollTo({ top: 0, behavior: 'smooth' });
          }
      }

      const targetNode = document.querySelector('#main-blog-container');

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
  $( document ).ready(function() {
    blogpage.init();
  });
})(jQuery);
