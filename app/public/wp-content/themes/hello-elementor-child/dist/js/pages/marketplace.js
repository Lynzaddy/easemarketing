"use strict";function setQueryStringParameter(e,t){const a=new URLSearchParams;e.map(e=>a.append("categories",e));const c=a.toString()?"?".concat(a):"";window.history.replaceState({},"",decodeURIComponent("".concat(window.location.pathname).concat(c)))}function getQueryStringCategories(){return new URLSearchParams(window.location.search).getAll("categories")}function getQueryStringTags(){return new URLSearchParams(window.location.search).getAll("tags")}const marketplacepage={init:function(){this.marketplaceFilter(),this.tagClick()},marketplaceFilter:function(){let e,t,a=$(".filter-button-new"),c=$(".marketplace-list .row"),n=$(".search-bar form"),r=document.querySelector(".filter-tag-container"),o=document.querySelector(".tag-hidden"),l=document.querySelector(".loader"),i=[];function s(){t=$(".search-bar").find("input").val();const a=Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(e=>e.value);setQueryStringParameter(a,i),function(){const e=document.querySelectorAll('input[type="checkbox"]:checked');console.log(e);document.querySelectorAll(".tag-filter").forEach(e=>{e.classList.add("tag-hidden")}),e.forEach(e=>{const t=document.querySelector("#".concat(e.value,"-tag"));if(t)t.classList.remove("tag-hidden");else{let t=o.cloneNode(!0);t.id="".concat(e.value,"-tag"),t.dataset.name=e.dataset.name,t.dataset.id=e.value,r.style.display="flex",t.dataset.value=e.value,t.classList.add("tag-filter"),t.classList.remove("tag-hidden"),t.querySelector(".tag-text").innerHTML=e.dataset.name,r.appendChild(t),t.addEventListener("click",m)}})}(),0===a.length&&0===i.length&&(posts_per_page=6,paged=1),e={action:"load_marketplace",tags:i,keyword:t},$.ajax({url:ajaxurl,type:"post",data:e,success:function(e){l.classList.remove("loaderActive"),response_ccccc=$(e).find(".row").html(),e.length?(c.html(response_ccccc),d()):c.html('<h2 class="col-lg-12 no-result">Whoops! No partner matches your search.</h2>'),setTimeout(()=>{document.querySelectorAll(".tags-container .tag").forEach(e=>{e.removeEventListener("click",g),e.addEventListener("click",g)})},200)}})}function d(){$(".page-template-marketplace .card .text-wrap h3").matchHeight(),$(".page-template-marketplace .card .text-wrap .excerpt").matchHeight()}function u(e){let t=e.target.checked,a=e.target.value;if(t)i.push({tag:a,taxonomy:"partner_types"});else{const e=i.findIndex(e=>e.tag===a);-1!==e&&i.splice(e,1)}}function g(e){let t=e.currentTarget,a=t.dataset.id,n=(t.dataset.name,t.dataset.taxonomy);if(!i.some(e=>e.tag===a)){c.empty();let e=document.querySelector("input#".concat(a));if(e){e.parentElement.nextElementSibling.style.color="#F06149",e.checked=!0}i.push({tag:a,taxonomy:n}),l.classList.add("loaderActive"),s()}}function m(e){console.log("removeFilterTag");let t=e.currentTarget,a=t.dataset.id,n=document.querySelector("input#".concat(a));if(i.some(e=>e.tag===a)){const e=i.findIndex(e=>e.tag===a);i.splice(e,1),0===i.length&&(r.style.display="none")}if(n){n.parentElement.nextElementSibling.style.color="#414245",n.checked=!1,t.remove(),c.empty(),l.classList.add("loaderActive"),s()}}return(getQueryStringCategories().length||getQueryStringTags().length)&&(getQueryStringCategories().forEach(e=>{let t=document.querySelector("input#".concat(e));if(t){i.push({tag:e,taxonomy:"partner_types"}),t.parentElement.nextElementSibling.style.color="#F06149",t.checked=!0}}),c.empty(),l.classList.add("loaderActive"),s()),d(),a.on("click",(function(e){e.preventDefault(),c.empty(),l.classList.add("loaderActive"),s()})),n.on("submit",(function(e){e.preventDefault(),c.empty(),l.classList.add("loaderActive"),s()})),document.querySelectorAll('input[type="checkbox"]').forEach(e=>{e.addEventListener("click",(function(e){let t=e.currentTarget.checked,a=e.currentTarget.parentElement.nextElementSibling;a.style.color=t?"#F06149":"#414245"}))}),document.querySelector(".dropdown-menu").addEventListener("click",(function(e){e.stopPropagation()})),document.querySelectorAll(".tags-container .tag").forEach(e=>{e.addEventListener("click",g)}),document.querySelectorAll(".checkbox-container input").forEach(e=>{e.addEventListener("click",u)}),!1},tagClick:function(){function e(){function e(){window.scrollTo({top:0,behavior:"smooth"})}document.querySelectorAll(".tag").forEach(t=>t.addEventListener("click",e))}const t=document.querySelector(".listing-section");new MutationObserver((t,a)=>{for(const a of t)"childList"===a.type&&e()}).observe(t,{attributes:!0,childList:!0,subtree:!0}),e()}};jQuery,marketplacepage.init();