"use strict";function setQueryStringParameter(e,t){const n=new URLSearchParams;e.map(e=>n.append("categories",e)),t.map(e=>n.append("tags",e));const r=n.toString()?"?".concat(n):"";window.history.replaceState({},"",decodeURIComponent("".concat(window.location.pathname).concat(r)))}function getQueryStringCategories(){return new URLSearchParams(window.location.search).getAll("categories")}function getQueryStringTags(){return new URLSearchParams(window.location.search).getAll("tags")}!function(e){const t={init:function(){this.blogFilter(),this.blogLoad(),this.callAJAX(),this.tagClick()},callAJAX:function(t){if(t)return new Promise((n,r)=>{e.ajax({url:ajaxurl,type:"post",data:t,cache:!1,async:!0,success:function(e){n(e)},error:function(e,t,n){r(n)}})})},blogLoad:function(){let e=document.querySelector("[href*='/blog']");e&&e.classList.add("active")},blogFilter:function(){e(".filter-dropdown .dropdown-item").not(".reset-button");let n,r,c,a,o,i=e(".reset-button"),l=e(".card-container"),s=e(".search-bar form"),d=document.querySelector(".dropdown-toggle");const u=document.querySelector(".featured-post-container"),g=document.querySelector(".reset-filter-container");let m=document.querySelector(".filter-button-new"),h=document.querySelector(".filter-tag-container"),p=document.querySelector(".tag-hidden"),f=document.querySelector(".loader"),y=[];function v(e){let t=e.currentTarget,n=t.dataset.id,r=t.dataset.name;if(!y.includes(n)){let e=p.cloneNode(!0);l.empty(),h.style.display="flex",e.classList.remove("tag-hidden"),e.querySelector(".tag-text").innerHTML=r,e.dataset.id=n,e.addEventListener("click",S),y.push(n),h.appendChild(e),f.classList.add("loaderActive"),b()}}function L(e){console.log("removeFilterTag");let t=e.currentTarget,n=(t.id,t.dataset.id),r=document.querySelector("input#".concat(n));if(r){r.parentElement.nextElementSibling.style.color="#414245",r.checked=!1,t.remove(),b()}}function S(e){console.log("removeTag");let t=e.currentTarget,n=t.dataset.id;y.includes(n)&&(y.splice(y.indexOf(n),1),0===y.length&&(h.style.display="none"),t.remove(),l.empty(),f.classList.add("loaderActive"),b())}function b(){r=e("#filtermarketplace").find(".dropdown-item.active").attr("href"),c=e(".search-bar").find("input").val();const i=Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(e=>e.value);setQueryStringParameter(i,y),function(){const e=document.querySelectorAll('input[type="checkbox"]:checked');document.querySelectorAll(".tag-filter").forEach(e=>{e.classList.add("tag-hidden")}),e.forEach(e=>{const t=document.querySelector("#".concat(e.value,"-tag"));if(t)t.classList.remove("tag-hidden");else{let t=p.cloneNode(!0);t.id="".concat(e.value,"-tag"),t.dataset.name=e.dataset.name,t.dataset.id=e.value,h.style.display="flex",t.dataset.value=e.value,t.classList.add("tag-filter"),t.classList.remove("tag-hidden"),t.querySelector(".tag-text").innerHTML=e.dataset.name,h.appendChild(t),t.addEventListener("click",L)}})}(),0===i.length&&0===y.length&&(o=6,a=1),u&&(c||i.length||y.length?(u.classList.add("hidden"),g.classList.remove("reset-filter-hide")):(u.classList.remove("hidden"),g.classList.add("reset-filter-hide"))),g&&(c||i.length||y.length?g.classList.remove("reset-filter-hide"):g.classList.add("reset-filter-hide")),n={action:"load_blogs",categories:i,tags:y,keyword:c,pg:a,posts_per_page:o},t.callAJAX(n).then(t=>{f.classList.remove("loaderActive"),t.length?(t.replaceAll("wp-admin/admin-ajax.php","blog"),response_ccccc=e(t).html(),l.html(response_ccccc)):l.html('<h2 class="no-result">There are no posts matching your filters.</h2>'),setTimeout(()=>{document.querySelectorAll(".tags-container .tag").forEach(e=>{e.removeEventListener("click",v),e.addEventListener("click",v)})},200)}).catch(e=>{console.log(e)})}return(getQueryStringCategories().length||getQueryStringTags().length)&&(getQueryStringCategories().forEach(e=>{let t=document.querySelector("input#".concat(e));if(t){t.parentElement.nextElementSibling.style.color="#F06149",t.checked=!0}}),getQueryStringTags().forEach(e=>{let t=p.cloneNode(!0);l.empty(),h.style.display="flex",t.classList.remove("tag-hidden"),t.querySelector(".tag-text").innerHTML=jQuery('[data-id="'.concat(e,'"]')).first().data("name"),t.dataset.id=e,t.addEventListener("click",S),y.push(e),h.appendChild(t)}),b()),document.querySelectorAll(".tags-container .tag").forEach(e=>{e.addEventListener("click",v)}),document.querySelectorAll('input[type="checkbox"]').forEach(e=>{e.addEventListener("click",(function(e){let t=e.currentTarget.checked,n=e.currentTarget.parentElement.nextElementSibling;n.style.color=t?"#F06149":"#414245"}))}),document.querySelector(".dropdown-menu").addEventListener("click",(function(e){e.stopPropagation()})),i.on("click",(function(t){t.preventDefault(),l.empty(),o=6,a=1,d.innerHTML="Filter posts",h.querySelectorAll(".tag:not(.tag-hidden)").forEach(e=>{e.remove()}),e(".filter-dropdown").find('input[type="checkbox"]:checked').prop("checked",!1),e(".dropdown-item-new").removeAttr("style"),e(".search-bar").find("input").val(""),h.style.display="none",categories=[],y=[],f.classList.add("loaderActive"),b()})),m.addEventListener("click",(function(e){e.preventDefault(),l.empty(),o=-1,a=1,f.classList.add("loaderActive"),m.parentElement.classList.remove("show"),b()})),s.on("submit",(function(e){e.preventDefault(),l.empty(),o=-1,a=1,f.classList.add("loaderActive"),b()})),e(".cat-tags a").on("click",(function(e){return e.preventDefault(),!1})),!1},tagClick:function(){function e(){function e(){window.scrollTo({top:0,behavior:"smooth"})}document.querySelectorAll(".tag").forEach(t=>t.addEventListener("click",e))}const t=document.querySelector("#main-blog-container");new MutationObserver((t,n)=>{for(const n of t)"childList"===n.type&&e()}).observe(t,{attributes:!0,childList:!0,subtree:!0}),e()}};e(document).ready((function(){t.init()}))}(jQuery);