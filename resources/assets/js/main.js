!function e(t,i,n){function s(a,o){if(!i[a]){if(!t[a]){var u="function"==typeof require&&require;if(!o&&u)return u(a,!0);if(r)return r(a,!0);var l=new Error("Cannot find module '"+a+"'");throw l.code="MODULE_NOT_FOUND",l}var c=i[a]={exports:{}};t[a][0].call(c.exports,function(e){var i=t[a][1][e];return s(i?i:e)},c,c.exports,e,t,i,n)}return i[a].exports}for(var r="function"==typeof require&&require,a=0;a<n.length;a++)s(n[a]);return s}({1:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}(),r=e("../libs/elife-utils")();t.exports=function(){function e(t){var i=arguments.length<=1||void 0===arguments[1]?window:arguments[1],s=arguments.length<=2||void 0===arguments[2]?document:arguments[2];n(this,e),t&&(this.window=i,this.doc=s,this.$elm=t,this.$elm.classList.add("article-download-links-list--js"),this.$elm.classList.add("visuallyhidden"),this.moveList(),this.$toggler=this.doc.querySelector(".content-header__download_link"),this.$toggler.addEventListener("click",this.toggle.bind(this)))}return s(e,[{key:"moveList",value:function(){var e=this.doc.querySelector(".content-header_top"),t=e.querySelector(".content-header__download_link").nextElementSibling;e.insertBefore(this.$elm,t)}},{key:"toggle",value:function(e){e.preventDefault(),e.stopPropagation(),this.isOpen()?this.close():this.open()}},{key:"isOpen",value:function(){return!this.$elm.classList.contains("visuallyhidden")}},{key:"open",value:function(){this.$elm.classList.remove("visuallyhidden"),this.window.addEventListener("click",this.checkForClose.bind(this))}},{key:"checkForClose",value:function(e){r.areElementsNested(this.$elm,e.target)||this.close()}},{key:"close",value:function(){this.$elm.classList.add("visuallyhidden"),this.window.removeEventListener("click",this.checkForClose.bind(this))}}]),e}()},{"../libs/elife-utils":11}],2:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}(),r=e("../libs/elife-utils")();t.exports=function(){function e(t){var i=this,s=arguments.length<=1||void 0===arguments[1]?window:arguments[1],a=arguments.length<=2||void 0===arguments[2]?document:arguments[2];return n(this,e),t?(this.window=s,this.window.HTMLAudioElement?(console.log("Initialising Audio Player..."),this.$elm=t,this.$audioElement=this.$elm.querySelector("audio"),this.$audioElement?(this.uniqueId=r.uniqueIds.get("audio",a),this.$elm.id=this.uniqueId,this.$playButton=e.buildPlayButton(this),this.$icon=this.$playButton.querySelector(".audio-player__toggle_play_icon"),this.$title=this.prepare$title(this.$elm.querySelector(".audio-player__header"),a),this.$progressTrack=e.buildProgressIndicator(this),this.$progressBar=this.$progressTrack.querySelector('[class*="progress_bar"]'),this.$timeIndicators=e.buildTimeIndicators(this),this.$currentTime=this.$timeIndicators.querySelector('[class*="current_time"]'),this.$duration=this.$timeIndicators.querySelector('[class*="duration"]'),this.duration=null,this.isPlaying=!1,this.$elm.classList.add("audio-player--js"),this.$playButton.classList.add("loading"),this.$audioElement.addEventListener("loadedmetadata",function(){i.playerReady(i)}),this.usingMetadata=!1,void this.loadMetadata(this.$elm.dataset.episodeNumber)):void console.warn("No audio element found")):void console.warn("Audio element not supported")):void console.warn("No element provided")}return s(e,[{key:"playerReady",value:function t(i){i.duration=i.$audioElement.duration,i.$duration.innerHTML=e.secondsToMinutes(i.duration),i.$playButton.addEventListener("click",function(){i.togglePlay(i.$audioElement,i.$playButton)},!1),i.$audioElement.addEventListener("timeupdate",i.update.bind(i)),i.window.addEventListener("hashchange",i.seekNewTime.bind(i)),i.window.addEventListener("load",i.seekNewTime.bind(i)),this.$playButton.classList.remove("loading");var t=void 0;try{t=new CustomEvent("playerReady",{detail:this.uniqueId})}catch(n){t=document.createEvent("playerReady"),t.initCustomEvent("playerReady",!0,!0,{detail:this.uniqueId})}i.window.dispatchEvent(t)}},{key:"prepare$title",value:function(e,t){var i=t.createElement("span");try{i.innerHTML=e.innerHTML}catch(n){return}return i.classList.add("audio-player__title"),e.innerHTML="",e.appendChild(i),i}},{key:"togglePlay",value:function(e,t){this.isPlaying?this.pause(e,t):this.play(e,t)}},{key:"play",value:function(t,i){t.play(),e.updateIconState(this.$icon,"pause"),i.classList.add("audio-player__toggle_play--pauseable"),i.classList.remove("audio-player__toggle_play--playable"),this.isPlaying=!0}},{key:"pause",value:function(t,i){t.pause(),e.updateIconState(this.$icon,"play"),i.classList.add("audio-player__toggle_play--playable"),i.classList.remove("audio-player__toggle_play--pauseable"),this.isPlaying=!1}},{key:"update",value:function(){var t=Math.floor(this.$audioElement.currentTime),i=t/this.duration*100,n=e.secondsToMinutes(t);if(this.$progressBar.style.width=i+"%",this.$currentTime.innerHTML=n,this.usingMetadata){var s=this.getCurrentChapterNumber();this.setCurrentChapterMetadata(this.getChapterMetadataAtTime(t,this.chapterMetadata)),this.getCurrentChapterMetadata().number!==s&&this.changeChapter(this.getCurrentChapterNumber(),this.getCurrentChapterMetadata().title,this.$elm)}this.$audioElement.ended&&(e.updateIconState(this.$icon,"play"),this.isPlaying=!1)}},{key:"changeChapter",value:function(e,t,i){this.setTitle(this.episodeTitle,t);var n=void 0;try{n=new CustomEvent("chapterChanged",{detail:e})}catch(s){n=document.createEvent("chapterChanged"),n.initCustomEvent("chapterChanged",!0,!0,{detail:e})}i.dispatchEvent(n)}},{key:"seekNewTime",value:function(e){var t,i=!1;try{t=e.newURL.substring(e.newURL.indexOf("#")+1),i=!0}catch(e){t=this.window.location.hash.substring(1),i=!1}!isNaN(t)&&t>=0&&(this.seek(t,this.$audioElement),!this.isPlaying&&i&&this.play(this.$audioElement,this.$playButton))}},{key:"handleSeek",value:function(e,t){var i=parseInt(e.offsetX,10),n=t.$progressTrack.clientWidth,s=i/parseInt(n,10);this.seek(s*t.duration,t.$audioElement)}},{key:"seek",value:function(e,t){t.currentTime=e,this.update()}},{key:"setTitle",value:function(e,t){this.title=e,t&&(this.title+=": "+t),this.$title.innerHTML=this.title}},{key:"getCurrentChapterMetadata",value:function(){return this.currentChapterMetadata}},{key:"setCurrentChapterMetadata",value:function(e){this.currentChapterMetadata=e}},{key:"getCurrentChapterNumber",value:function(){return this.getCurrentChapterMetadata().number||0}},{key:"getChapterMetadataAtTime",value:function(e,t){if(!t)return"";var i="",n=0;return t.forEach(function(t,s,r){var a=parseInt(t.time,10),o=s<r.length-1?r[s+1].time:null;e>=a&&(!o||e<o)&&(i=t.title,n=t.number)}),{title:i,number:n}}},{key:"processMetadata",value:function(e){this.episodeTitle="Episode "+e.number,this.setTitle(this.episodeTitle),this.chapterMetadata=this.prepareChapterMetadata(e),this.currentChapterMetadata={number:0,title:""}}},{key:"prepareChapterMetadata",value:function(e){var t=[];return e.chapters.forEach(function(e){t.push({time:e.time,number:e.number,title:e.number+". "+e.title})}),t}},{key:"loadMetadata",value:function(){try{this.processMetadata(JSON.parse(this.$elm.dataset.metadata.replace(/'/g,'"'))),this.usingMetadata=!0}catch(e){console.error(e),this.usingMetadata=!1}}}],[{key:"secondsToMinutes",value:function(e){var t=parseInt(e,10),i=Math.floor(t/60),n=t%60;return n<=9&&(n="0"+n),i+":"+n}},{key:"updateIconState",value:function(t,i){"play"!==i&&"pause"!==i||(t.src=e.getIconPath(i),t.alt=i)}},{key:"buildProgressIndicator",value:function(e){var t=r.buildElement("div",["audio-player__progress"],"","#"+e.uniqueId+' [class*="audio-player__container"]');return r.buildElement("div",["audio-player__progress_bar"],"",t),t.addEventListener("click",function(t){e.handleSeek(t,e)},!1),t}},{key:"buildPlayButton",value:function(t){var i=r.buildElement("button",["audio-player__toggle_play"],"","#"+t.uniqueId+' [class*="audio-player"]',!0),n=r.buildElement("img",["audio-player__toggle_play_icon"],"",i);return n.src=e.getIconPath("play"),n.alt="Play",i}},{key:"buildTimeIndicators",value:function(e){var t=e.uniqueId,i=r.buildElement("div",["audio-player__times"],"","#"+t+" [class*=audio-player__header]",!0);return r.buildElement("span",["audio-player__current_time"],"0:00",i),r.buildElement("span",["audio-player__duration"],"0:00",i),i}},{key:"getIconPath",value:function(e){if("play"===e||"pause"===e)return"../../assets/img/icons/audio-"+e+".svg"}}]),e}()},{"../libs/elife-utils":11}],3:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}(),r=e("../libs/elife-utils")();t.exports=function(){function e(t){var i=arguments.length<=1||void 0===arguments[1]?window:arguments[1],s=arguments.length<=2||void 0===arguments[2]?document:arguments[2];if(n(this,e),t){var a="linear-gradient(to top, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5))";this.window=i,this.doc=s,this.$elm=t,this.sourceToUse=this.calcSourceToUse(this.$elm,r.isHighDpr(this.window)),this.$elm.style.backgroundImage=this.setBackground(this.sourceToUse,a)}}return s(e,[{key:"setBackground",value:function(e,t){return e&&e.length&&0!==e.length?t+", url("+e+")":""}},{key:"calcSourceToUse",value:function(e,t){var i="",n="";return e?(e.dataset?(n=e.dataset.highResImageSource,i=e.dataset.lowResImageSource):(n=e.getAttribute("data-highResImageSource"),i=e.getAttribute("data-lowResImageSource")),t&&!n||!t&&!i?"":t?n:i):""}}]),e}()},{"../libs/elife-utils":11}],4:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(t){var i=arguments.length<=1||void 0===arguments[1]?window:arguments[1],s=arguments.length<=2||void 0===arguments[2]?document:arguments[2];if(n(this,e),t){this.window=i,this.doc=s,this.$elm=t,this.$elm.classList.add("content-header-article--js"),this.breakpointInPx=768,this.currentView=this.calcCurrentView(this.breakpointInPx),this.authors=t.querySelectorAll(".content-header__author_list_item"),this.institutions=t.querySelectorAll(".content-header__institution_list_item"),this.hasToggleAuthor=!1,this.hasToggleInstitution=!1,this.hideAllExcessItems("author",this.authors),this.hideAllExcessItems("institution",this.institutions);var r=this;this.window.addEventListener("resize",function(){var e=r.calcCurrentView(r.breakpointInPx);e!==r.currentView&&(r.currentView=e,r.handleAnyExcessItems("author",r.authors),r.handleAnyExcessItems("institution",r.institutions))})}}return s(e,[{key:"handleAnyExcessItems",value:function(e,t){var i=this.$elm.querySelector(".content-header__item_toggle");if(i&&i.innerHTML.indexOf("less")>-1&&"wide"===this.currentView)this.clearExcessMark(t),this.toggleExcessItems(t);else{this.clearExcessMark(t);var n=this.getExcessItems(e,t);this.markAsExcess(n),this.toggleExcessItems(t),this.markLastNonExcessItem(e,t)}}},{key:"hideAllExcessItems",value:function(e,t){var i=this.getExcessItems(e,t);this.markAsExcess(i),this.toggleExcessItems(t),this.addTrailingText(e,t)}},{key:"getDefaultMaxItems",value:function(e){if("wide"===this.currentView){if("author"===e)return 16;if("institution"===e)return 10}else{if("author"===e)return 1;if("institution"===e)return 0}return null}},{key:"getExcessItems",value:function(e,t){if("author"!==e&&"institution"!==e)return null;var i=this.getDefaultMaxItems(e);return t.length>i?[].slice.call(t,i):[]}},{key:"markAsExcess",value:function(e){e.forEach(function(e){e.classList.add("excess-item")})}},{key:"clearExcessMark",value:function(e){[].forEach.call(e,function(e){e.classList.remove("excess-item")})}},{key:"toggleExcessItems",value:function(e){[].forEach.call(e,function(e){e.classList.contains("excess-item")?e.classList.add("visuallyhidden"):e.classList.remove("visuallyhidden")})}},{key:"calcCurrentView",value:function(e){return this.window.matchMedia("(min-width: "+e+"px)").matches?"wide":"narrow"}},{key:"markLastNonExcessItem",value:function(e,t){var i=null,n=!1;if([].forEach.call(t,function(s,r){t[r].classList.remove("content-header__"+e+"--last-non-excess"),s.classList.contains("excess-item")&&!n&&(i=r-1,n=!0)}),null!==i&&i>-1){var s=t[i].querySelector(".content-header__"+e);s&&s.classList.add("content-header__"+e+"--last-non-excess")}}},{key:"addTrailingText",value:function(e,t){"author"===e&&t.length>this.getDefaultMaxItems("author")&&(this.hasToggleAuthor||(this.buildSeeMoreLessToggle("author"),this.hasToggleAuthor=!0)),"institution"===e&&t.length>this.getDefaultMaxItems("institution")&&(this.hasToggleInstitution||(this.buildSeeMoreLessToggle("institution"),this.hasToggleInstitution=!0)),this.markLastNonExcessItem(e,t)}},{key:"buildSeeMoreLessToggle",value:function(e){var t=this,i=this.doc.createElement("li"),n="see&nbsp;all",s="see&nbsp;less";i.setAttribute("aria-hidden","true"),i.classList.add("content-header__item_toggle","content-header__item_toggle--"+e),i.innerHTML="&nbsp;&hellip;&nbsp;"+n,i.addEventListener("click",function(e){var i=e.target;i.innerHTML.indexOf(n)>-1?([].forEach.call(t.doc.querySelectorAll(".content-header__item_toggle"),function(e){e.innerHTML="&nbsp;"+s}),t.clearExcessMark(t.authors),t.clearExcessMark(t.institutions),t.toggleExcessItems(t.authors),t.toggleExcessItems(t.institutions)):([].forEach.call(t.doc.querySelectorAll(".content-header__item_toggle"),function(e){e.innerHTML="&nbsp;&hellip;&nbsp;"+n}),t.hideAllExcessItems("author",t.authors),t.hideAllExcessItems("institution",t.institutions))}),this.$elm.querySelector(".content-header__"+e+"_list").appendChild(i)}}]),e}()},{}],5:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(t){var i=arguments.length<=1||void 0===arguments[1]?window:arguments[1],s=arguments.length<=2||void 0===arguments[2]?document:arguments[2];n(this,e),t&&(this.window=i,this.doc=s,this.$elm=t)}return s(e,[{key:"moveWithinDom",value:function(){this.$elm.classList.add("main-menu--js");var e=this.doc.querySelector(".global-wrapper");e&&e.insertBefore(this.$elm,e.firstElementChild)}},{key:"isOpen",value:function(){return this.$elm.classList.contains("main-menu--shown")}},{key:"close",value:function(){this.$elm.classList.remove("main-menu--shown"),this.doc.querySelector(".global-wrapper").classList.remove("pull-offscreen-right")}},{key:"open",value:function(){this.$elm.classList.add("main-menu--shown"),this.doc.querySelector(".global-wrapper").classList.add("pull-offscreen-right")}}]),e}()},{}],6:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(t){var i=arguments.length<=1||void 0===arguments[1]?window:arguments[1],s=arguments.length<=2||void 0===arguments[2]?document:arguments[2];return n(this,e),t?(console.log("Initialising Chapter listing item..."),this.$elm=t,this.startTime=t.dataset.startTime,void(!this.startTime||isNaN(this.startTime)||this.startTime<0||(this.window=i,this.document=s,i.addEventListener("playerReady",this.listenForChapterChange.bind(this)),this.$link=this.createLink(s,this.$elm,this.startTime),this.setupEventHandlers(this.$link)))):void console.warn("No element provided")}return s(e,[{key:"listenForChapterChange",value:function(e){var t=this.document.querySelector("#"+e.detail);t&&t.addEventListener("chapterChanged",this.indicateChapterChanged.bind(this))}},{key:"createLink",value:function(e,t,i){var n=t.querySelector(".teaser__header_text");if(n){var s=void 0,r=void 0;try{r=n.querySelector(".teaser__header_text_link"),s=r.innerHTML,r.parentNode.removeChild(r)}catch(a){s=n.innerHTML}var o=e.createElement("a");return o.innerHTML=s,o.setAttribute("href","#"+i),o.classList.add("teaser__header_text_link"),n.innerHTML="",n.appendChild(o),o}}},{key:"indicateChapterChanged",value:function(e){var t=e.detail;t===this.window.parseInt(this.$elm.dataset.chapterNumber)?this.$elm.classList.add("current-chapter"):this.$elm.classList.remove("current-chapter")}},{key:"setupEventHandlers",value:function(e){e.addEventListener("chapterChanged",this.indicateChapterChanged)}}]),e}()},{}],7:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}(),r=e("../libs/elife-utils")();t.exports=function(){function e(t){var i=this,s=(arguments.length<=1||void 0===arguments[1]?window:arguments[1],arguments.length<=2||void 0===arguments[2]?document:arguments[2]);n(this,e),t&&(this.$container=t.querySelector("fieldset"),this.$form=t.querySelector("form"),this.$input=t.querySelector('input[type="search"]'),this.$limit=t.querySelector('input[type="checkbox"]'),this.$elm=t,this.$searchButton=t.querySelector('button[type="submit"]'),this.$resetButton=t.querySelector('button[type="reset"]'),this.$inner=t.querySelector(".search-box__inner"),this.$input&&(this.isSearchLimited=this.$limit&&this.$limit.checked,this.$elm.classList.add("search-box--js"),this.$form.setAttribute("autocomplete","off"),s.querySelector(".search-box__output")||(this.$output=s.createElement("div"),this.$output.innerHTML="",this.$output.classList.add("search-box__output"),this.$output.addEventListener("keyup",function(t){e.handleKeyEntry(t,i)}),this.$output.addEventListener("click",function(e){i.useSuggestion(e.target)}),this.$inner.appendChild(this.$output)),this.keywords=[],this.$resetButton.addEventListener("click",this.reset.bind(this)),this.$input.addEventListener("keyup",function(t){e.handleKeyEntry(t,i)}),this.$input.addEventListener("paste",this.showResetButton.bind(this)),e.setKeywords(["Xiao-Dong Li","Zhijian J Chen","Cell biology","Immunology","bacteria"],this)))}return s(e,[{key:"reset",value:function(){this.hideResetButton(),this.$output&&(this.$output.innerHTML=""),this.$input.focus()}},{key:"hideResetButton",value:function(){this.$elm.classList.remove("search-box--populated")}},{key:"showResetButton",value:function(){this.$elm.classList.add("search-box--populated")}},{key:"nextSuggestion",value:function(e){this.$output&&(e===this.$input?this.$output.querySelector("ul li:first-child").focus():e.nextElementSibling?e.nextElementSibling.focus():this.$input.focus())}},{key:"prevSuggestion",value:function(e){this.$output&&(e===this.$input?this.$output.querySelector("ul li:last-child").focus():e.previousElementSibling?e.previousElementSibling.focus():this.$input.focus())}},{key:"useSuggestion",value:function(e){this.$input.value=e.innerHTML.replace(/<\/?strong>/g,""),this.$output&&(this.$output.innerHTML="",this.$input.value.length&&this.$form.submit())}},{key:"filterKeywordsBySearchTerm",value:function(t,i){var n=void 0;if(i){n=t.filter(function(e){return e.toLowerCase().indexOf(i.toLowerCase())!==-1}),n.sort();for(var s=0;s<n.length;s+=1)n[s]=e.embolden(n[s],i)}return n}},{key:"display",value:function(e,t){var i="";t&&(t.innerHTML="",this.nudgeOutputVertically("-47px"),e&&e.length&&(e.forEach(function(e){i+='<li tabindex="0" class="search-box__suggestion">'+e+"</li>"}),i="<ul>"+i+"</ul>",t.innerHTML=i))}},{key:"nudgeOutputVertically",value:function(e){var t=void 0;"string"==typeof e&&e.indexOf("px")===e.length-2?t=e:isNaN(e)||(t=e+"px"),r.updateElementTranslate(this.$output,[0,t])}},{key:"toggleSearchLimiting",value:function(){this.isSearchLimited=!this.isSearchLimited}}],[{key:"handleKeyEntry",value:function(t,i){var n=t.target;if(t.keyCode&&9!==t.keyCode)switch(t.keyCode){case 40:i.nextSuggestion(n);break;case 38:i.prevSuggestion(n);break;case 13:i.useSuggestion(n);break;default:i.display(i.filterKeywordsBySearchTerm(e.getKeywords(i),i.$input.value),i.$output),i.$input.value.length>0?i.showResetButton():i.hideResetButton()}}},{key:"getKeywords",value:function(e){return e.keywords}},{key:"setKeywords",value:function(e,t){t.keywords=e}},{key:"embolden",value:function(e,t){if(t.indexOf("<strong>")>-1)return e;var i=new RegExp(t,"i"),n=e.match(i)?e.match(i)[0]:null;return n?e.replace(n,"<strong>"+n+"</strong>"):e}}]),e}()},{"../libs/elife-utils":11}],8:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(t){n(this,e),t&&(this.$elm=t,this.$elm.classList.add("select-nav--js"),this.$elm.querySelector("select").addEventListener("change",this.triggerSubmit.bind(this)))}return s(e,[{key:"triggerSubmit",value:function(){this.$elm.submit()}}]),e}()},{}],9:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}(),r=e("../libs/elife-utils")();t.exports=function(){function t(i){var s=arguments.length<=1||void 0===arguments[1]?window:arguments[1],r=arguments.length<=2||void 0===arguments[2]?document:arguments[2];if(n(this,t),i){this.$elm=i,this.window=s,this.doc=r;var a=e("./SearchBox"),o=i.querySelector('[data-behaviour="SearchBox"]');this.searchBox=new a(o,this.window,r);var u=i.querySelector('[rel="search"]');u&&(this.searchToggle=u.parentNode,this.searchToggle.addEventListener("click",this.toggleSearchBox.bind(this))),this.$pageOverlay=null;var l=r.querySelector("#mainMenu");if(l){var c=e("./MainMenu");this.mainMenu=new c(l),this.$mainMenuToggle=this.$elm.querySelector('a[href="#mainMenu"]'),this.$mainMenuToggle&&(this.mainMenu.moveWithinDom(),this.$mainMenuToggle.addEventListener("click",this.toggleMainMenu.bind(this)))}}}return s(t,[{key:"toggleMainMenu",value:function(e){this.mainMenu.isOpen()?(this.mainMenu.close(),this.window.removeEventListener("keyup",this.checkForMenuClose.bind(this)),this.window.removeEventListener("click",this.checkForMenuClose.bind(this))):(this.mainMenu.open(),this.window.addEventListener("keyup",this.checkForMenuClose.bind(this)),this.window.addEventListener("click",this.checkForMenuClose.bind(this))),e.preventDefault(),e.stopPropagation()}},{key:"checkForMenuClose",value:function(e){(27===e.keyCode||"click"===e.type&&!r.areElementsNested(this.mainMenu.$elm,e.target))&&this.mainMenu.close()}},{key:"toggleSearchBox",value:function(e){e.preventDefault(),e.stopPropagation(),this.searchBoxIsOpen()?this.closeSearchBox():this.openSearchBox()}},{key:"searchBoxIsOpen",value:function(){return this.searchBox.$elm.classList.contains("search-box--shown")}},{key:"closeSearchBox",value:function(){this.searchBox.$elm.classList.remove("search-box--shown"),r.updateElementTranslate(this.searchBox.$elm,[0,"-40px"]),this.searchBox.$output&&(this.searchBox.$output.innerHTML=""),this.searchBox.$input.blur(),this.window.removeEventListener("keyup",this.checkForClose.bind(this)),this.window.removeEventListener("click",this.checkForClose.bind(this)),this.hidePageOverlay()}},{key:"checkForClose",value:function(e){(e.keyCode&&27===e.keyCode||"click"===e.type&&!r.areElementsNested(this.searchBox.$elm,e.target))&&this.closeSearchBox()}},{key:"openSearchBox",value:function(){var e=this,t=this.window.getComputedStyle(this.$elm).height,i=20,n=r.adjustPxString(t,i),s=150;r.updateElementTranslate(this.searchBox.$elm,[0,n]),r.invertPxString(this.window.getComputedStyle(this.searchBox.$container).height),this.searchBox.$elm.classList.add("search-box--shown"),this.window.addEventListener("keyup",this.checkForClose.bind(this)),this.window.addEventListener("click",this.checkForClose.bind(this)),this.window.setTimeout(function(){e.searchBox.$input.blur(),e.searchBox.$input.focus()},s),this.showPageOverlay()}},{key:"createPageOverlay",value:function(){var e="overlay--semi-white";this.$pageOverlay||(this.$pageOverlay=this.doc.createElement("div"),this.$pageOverlay.classList.add(e));var t=this.doc.querySelector(".global-inner");t.insertBefore(this.$pageOverlay,this.doc.querySelector(".site-header").nextElementSibling)}},{key:"showPageOverlay",value:function(){this.$pageOverlay||this.createPageOverlay(),this.$pageOverlay.style.display="block",this.$pageOverlay.style.height=this.doc.querySelector(".global-inner").getBoundingClientRect().height+"px"}},{key:"hidePageOverlay",value:function(){this.$pageOverlay.style.display="none"}}]),t}()},{"../libs/elife-utils":11,"./MainMenu":5,"./SearchBox":7}],10:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(t){n(this,e),this.$elm=t,this.$prev=document.createElement("div"),this.$next=document.createElement("div"),this.build(),this.$prev.addEventListener("click",this.prev),this.$next.addEventListener("click",this.next)}return s(e,[{key:"build",value:function(){}},{key:"prev",value:function(e){e.preventDefault()}},{key:"next",value:function(e){e.preventDefault()}},{key:"close",value:function(){}}]),e}()},{}],11:[function(e,t,i){"use strict";function n(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}var s=function(){function e(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}return function(t,i,n){return i&&e(t.prototype,i),n&&e(t,n),t}}();t.exports=function(){function e(e,t,i,n,s){var r=document.createElement(e),a="string"==typeof n?document.querySelector(n):n,o=function(){if(s){if("boolean"==typeof s)return a.firstElementChild;if("string"==typeof s)return document.querySelector(s);if(s instanceof HTMLElement)return s}}();return t.forEach(function(e){r.classList.add(e)}),i&&(r.innerHTML=i),a&&o?a.insertBefore(r,o):a.appendChild(r),r}function t(e,t){if(e instanceof HTMLElement&&Array.isArray(t)){var i=["webkitTransform","mozTransform","msTransform","oTransform","transform"],n=t[0],s=t[1]||0;i.forEach(function(t){e.style[t]="translate("+n+", "+s+")"})}}function i(e,t){var i=parseInt(e.match(/([-0-9.]+)px/)[1],10),n=i+t;return n+"px"}function r(e){var t=parseInt(e.match(/([-0-9.]+)px/)[1],10),i=t*-1;return i+"px"}function a(e,t){var i=e.compareDocumentPosition(t);return!!(i&e.DOCUMENT_POSITION_CONTAINED_BY||0===i)}function o(){return document.documentElement.clientWidth}function u(e){return!!e.devicePixelRatio&&e.devicePixelRatio>=2}var l=function(){var e=function(){function e(){n(this,e),this.used=[]}return s(e,[{key:"isValid",value:function(e,t){return!(this.used.indexOf(e)>-1)&&!(t&&t.querySelector&&"function"==typeof t.querySelector&&t.querySelector("#"+e))}},{key:"get",value:function(e,t){var i=""+e||"default_",n=(""+Math.random()).replace(/\./,""),s=i+n;return this.isValid(s)?s:void this.get(e,t)}}]),e}();return new e}();return{adjustPxString:i,areElementsNested:a,buildElement:e,getViewportWidth:o,invertPxString:r,isHighDpr:u,uniqueIds:l,updateElementTranslate:t}}},{}],12:[function(e,t,i){"use strict";window.localStorage&&document.querySelector&&window.addEventListener&&document.createElement("div").classList&&!function(){document.querySelector("html").classList.add("js");var t={};t.ArticleDownloadLinksList=e("./components/ArticleDownloadLinksList"),t.AudioPlayer=e("./components/AudioPlayer"),t.ContentHeaderArticle=e("./components/ContentHeaderArticle"),t.BackgroundImage=e("./components/BackgroundImage"),t.SelectNav=e("./components/SelectNav"),t.MainMenu=e("./components/MainMenu"),t.MediaChapterListingItem=e("./components/MediaChapterListingItem"),t.SiteHeader=e("./components/SiteHeader"),t.SearchBox=e("./components/SearchBox"),t.ViewerModal=e("./components/ViewerModal");var i=function(){function e(e){for(var i=e.getAttribute("data-behaviour").trim().split(" "),n=0;n<i.length;n+=1){var s=i[n];t[s]&&"function"==typeof t[s]&&new t[s](e,window,window.document)}}var i=document.querySelectorAll("[data-behaviour]");i&&[].forEach.call(i,e)};new i}()},{"./components/ArticleDownloadLinksList":1,"./components/AudioPlayer":2,"./components/BackgroundImage":3,"./components/ContentHeaderArticle":4,"./components/MainMenu":5,"./components/MediaChapterListingItem":6,"./components/SearchBox":7,"./components/SelectNav":8,"./components/SiteHeader":9,"./components/ViewerModal":10}]},{},[12]);
//# sourceMappingURL=main.js.map
