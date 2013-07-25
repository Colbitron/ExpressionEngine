/*!
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2013, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 2.0
 * @filesource
 */

jQuery(document).ready(function(){var a=jQuery;a.ajaxPrefilter(function(b,c,d){var e=EE.XID;_.has(b,"error")||d.error(function(a){_.defer(function(){throw[a.statusText,a.responseText];})});d.setRequestHeader("X-EEXID",e);d.complete(function(b){if(b=b.getResponseHeader("X-EEXID"))EE.XID=b,a('input[name="XID"]').filter('[value="'+e+'"]').val(b)})});a(document).bind("ajaxComplete",function(a,c){if(c.status&&401===+c.status)window.location=EE.BASE+"&"+c.responseText});!1 in document.createElement("input")&&
EE.insert_placeholders();a('a[rel="external"]').click(function(){window.open(this.href);return!1});EE.cp.zebra_tables();EE.cp.show_hide_sidebar();EE.cp.display_notices();EE.cp.deprecation_meaning();EE.notepad=function(){var b=a("#notePad"),c=a("#notepad_form"),d=a("#notePadTextEdit"),e=a("#notePadControls"),f=a("#notePadText");notepad_empty=f.text();current_content=d.val();return{init:function(){current_content&&f.html(current_content.replace(/</ig,"&lt;").replace(/>/ig,"&gt;").replace(/\n/ig,"<br />"));
b.click(EE.notepad.show);e.find("a.cancel").click(EE.notepad.hide);c.submit(EE.notepad.submit);e.find("input.submit").click(EE.notepad.submit);d.autoResize()},submit:function(){current_content=a.trim(d.val());var b=current_content.replace(/</ig,"&lt;").replace(/>/ig,"&gt;").replace(/\n/ig,"<br />");d.attr("readonly","readonly").css("opacity",0.5);e.find("#notePadSaveIndicator").show();a.post(c.attr("action"),{notepad:current_content,XID:EE.XID},function(){f.html(b||notepad_empty).show();d.attr("readonly",
!1).css("opacity",1).hide();e.hide().find("#notePadSaveIndicator").hide()},"json");return!1},show:function(){if(e.is(":visible"))return!1;var a="";f.hide().text()!==notepad_empty&&(a=f.html().replace(/<br>/ig,"\n").replace(/&lt;/ig,"<").replace(/&gt;/ig,">"));e.show();d.val(a).show().height(0).focus().trigger("keypress")},hide:function(){f.show();d.hide();e.hide();return!1}}}();EE.notepad.init();EE.cp.accessory_toggle();EE.cp.control_panel_search();a("h4","#quickLinks").click(function(){window.location.href=
EE.BASE+"&C=myaccount&M=quicklinks"}).add("#notePad").hover(function(){a(".sidebar_hover_desc",this).show()},function(){a(".sidebar_hover_desc",this).hide()}).css("cursor","pointer");EE.cp.logout_confirm()});EE.namespace=function(a){var a=a.split("."),b=EE;"EE"===a[0]&&(a=a.slice(1));for(var c=0,d=a.length;c<d;c+=1)"undefined"===typeof b[a[c]]&&(b[a[c]]={}),b=b[a[c]];return b};EE.namespace("EE.cp");
EE.cp.accessory_toggle=function(){$("#accessoryTabs li a").click(function(a){a.preventDefault();var a=$(this).parent("li"),b=$("#"+this.className);a.hasClass("current")?(b.slideUp("fast"),a.removeClass("current")):(a.siblings().hasClass("current")?(b.show().siblings(":not(#accessoryTabs)").hide(),a.siblings().removeClass("current")):b.slideDown("fast"),a.addClass("current"))})};
EE.cp.control_panel_search=function(){var a=$("#search"),b=a.clone(),c=$("#cp_search_form").find(".searchButton"),d;d=function(){var e=$(this).attr("action"),f={cp_search_keywords:$("#cp_search_keywords").val()};$.ajax({url:e,data:f,type:"POST",dataType:"html",beforeSend:function(){c.toggle()},success:function(e){c.toggle();a=a.replaceWith(b);b.html(e);$("#cp_reset_search").click(function(){b=b.replaceWith(a);$("#cp_search_form").submit(d);$("#cp_search_keywords").select();return!1})}});return!1};
$("#cp_search_form").submit(d)};
EE.cp.show_hide_sidebar=function(){var a={revealSidebarLink:"77%",hideSidebarLink:"100%"},b=$("#mainContent"),c=$("#sidebarContent"),d=b.height(),e=c.height(),f;"n"===EE.CP_SIDEBAR_STATE?(b.css("width","100%"),$("#revealSidebarLink").css("display","block"),$("#hideSidebarLink").hide(),c.show(),e=c.height(),c.hide()):(c.hide(),d=b.height(),c.show());f=e>d?e:d;$("#revealSidebarLink, #hideSidebarLink").click(function(){var e=$(this),g=e.siblings("a"),j="revealSidebarLink"===this.id;$.ajax({type:"POST",
dataType:"json",url:EE.BASE+"&C=myaccount&M=update_sidebar_status",data:{XID:EE.XID,show:j},success:function(){}});$("#sideBar").css({position:"absolute","float":"",right:"0"});e.hide();g.css("display","block");c.slideToggle();b.animate({width:a[this.id],height:j?f:d},function(){b.height("");$("#sideBar").css({position:"","float":"right"})});return!1})};
EE.cp.display_notices=function(){var a=["success","notice","error"];$(".message.js_hide").each(function(){for(i in a)$(this).hasClass(a[i])&&$.ee_notice($(this).html(),{type:a[i]})})};
EE.insert_placeholders=function(){$('input[type="text"]').each(function(){if(this.placeholder){var a=$(this),b=this.placeholder,c=a.css("color");""==a.val()&&a.data("user_data","n");a.focus(function(){a.css("color",c);a.val()===b&&(a.val(""),a.data("user_data","y"))}).blur(function(){if(""===a.val()||a.val===b)a.val(b).css("color","#888"),a.data("user_data","n")}).trigger("blur")}})};
EE.cp.logout_confirm=function(){$("#activeUser").one("mouseover",function(){var a=$('<div id="logOutConfirm">'+EE.lang.logout_confirm+" </div>"),b=30,c=b,d,e,f,h,g;f=function(){$(window).unbind("unload.logout");window.location=EE.BASE+"&C=login&M=logout"};h=function(){$.ajax({url:EE.BASE+"&C=login&M=logout",async:!$.browser.safari})};g=function(){if(1>b)return setTimeout(f,0);b===c&&$(window).bind("unload.logout",h);a.dialog("option","title",EE.lang.logout+" ("+(b--||"...")+")");d=setTimeout(g,1E3)};
e={Cancel:function(){$(this).dialog("close")}};e[EE.lang.logout]=f;a.dialog({autoOpen:!1,resizable:!1,modal:!0,title:EE.lang.logout,position:"center",minHeight:"0",buttons:e,beforeClose:function(){clearTimeout(d);$(window).unbind("unload.logout");b=c}});$("a.logOutButton",this).click(function(){$("#logOutConfirm").dialog("open");$(".ui-dialog-buttonpane button:eq(2)").focus();g();return!1})})};
EE.cp.deprecation_meaning=function(){$(".deprecation_meaning").click(function(a){a.preventDefault();$('<div class="alert">'+EE.developer_log.deprecation_meaning+" </div>").dialog({height:300,modal:!0,title:EE.developer_log.dev_log_help,width:460})})};EE.cp.zebra_tables=function(a){a=a||$("table");a.jquery||(a=$(a));$(a).find("tr").removeClass("even odd").filter(":even").addClass("even").end().filter(":odd").addClass("odd")};EE.grid_cache=[];var Grid={bind:function(){EE.grid_cache.push(arguments)}};
(function(){var a=$("head script");if(2<a.length){var b=console.groupCollapsed?"groupCollapsed":"log";console[b]("Found third party scripts in <head> tag.");console.log("Please use cp->add_to_foot() to add scripts. jQuery and the EE global will be moved down in a future release.");a.slice(2).each(function(){console.log(this.src&&this.src||"[Inline Script]")});"groupCollapsed"==b&&console.groupEnd()}})();
