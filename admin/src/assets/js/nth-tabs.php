<script>
(function ($) {
    $.fn.nthTabs = function (options) {
        var nthTabs = this;
        var defaults = {
            allowClose: true,
            active: true,
            location: true,
            fadeIn: true,
            rollWidth: nthTabs.width() - 120
        };
        var iframeHeight = $(window).height() - 72;
        var settings = $.extend({}, defaults, options);
        var handler = [];
        var frameName = 0;
        var lang_flag = ('<?=$Language?>' == 'en' ? `<h6 class="mt-3">EN</h6>` : `<h6 class="mt-3">中文</h6>`);
        var Info = koolajax.callback(getAccessRights());
        var String = Info.split('|');
        var DashboardArray = ['1470969182499','1471659520334','1537777261939','1367890494891','1467425756982','1459168516926','1333889012023'];
        var DashboardDisplay = '';
        $.each(String,function(key,Ids){
            if($.inArray(Ids, String) !== -1){
                if(Ids == '1470969182499'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1303366060847" title="${setLanguage('Home')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Home')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1471659520334'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1333944115663" title="${setLanguage('Items & Inventory')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Items & Inventory')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1537777261939'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1305863558827" title="${setLanguage('Logistics')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Logistics')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1367890494891'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1305261425806" title="${setLanguage('Customer')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('MCustomer')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1467425756982'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1333636232143" title="${setLanguage('Sales')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Sales')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1459168516926'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1305261692282" title="${setLanguage('Supplier')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Supplier')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                if(Ids == '1333889012023'){
                    DashboardDisplay += `
                    <div class="dropdown-item dropdown-item-tab list" content_id="1303718173457" title="${setLanguage('Accounts')}">
                        <div class="media media-dashboard server-log">
                            <div class="media-body">
                                <div class="data-info">
                                    <h6 class="">${setLanguage('Accounts')}</h6>
                                    <p class="">${setLanguage('Dashboard')}</p>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
            }
        });
        var template =
        `<div class="page-tabs user-profile-dropdown" id="div_Page_Tabs">
            <a href="#" class="roll-nav roll-nav-left"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></span></a>
            <div class="content-tabs">
                <div class="content-tabs-container">
                    <ul class="nav nav-tabs ul-dynamic-tab"></ul>
                </div>
            </div>
            <a href="#" class="roll-nav roll-nav-right" style="right: 200px !important;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a>
            <a href="#" class="roll-nav roll-nav-right" style="right: 150px !important;width: 55px !important;">
                <svg id="spin_icon" style="margin-top: 0px!important;color:#00ab55 !important;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader hidden"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
                <svg id="succ_icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <p id="p_Processing" class="hidden" style="font-size: 10px;margin-top: -22px;color:#00ab55 !important">${setLanguage('Processing')}</p>
            </a>
            <a href="#" class="roll-nav" style="right: 110px !important;" id="notificationDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
            </a>
            <div class="dropdown-menu position-absolute dropdown-notification" aria-labelledby="notificationDropdown">
                <div class="drodpown-title drodpown-title-tab message">
                    <h6 class="d-flex justify-content-between"><span class="align-self-center">${setLanguage('Dashboard')}</span></h6>
                </div>
                <div class="notification-scroll notification-scroll-tab ps ps--active-y div_Dashboard_List" style="overflow: auto !important;">
                    ${DashboardDisplay}
                </div>
            </div>
            <a href="#" class="roll-nav" style="right: 70px !important;" id="language-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <div class="flags-svg">${lang_flag}</div>
            </a>
            <div class="dropdown-menu position-absolute dropdown-tab" aria-labelledby="language-dropdown">
                <a class="dropdown-item dropdown-item-tab d-flex adynamic-language p-language span-responsive mt-2 ${'<?=$Language?>' == 'en' ? 'hidden' : ''}" data-lang="en" href="#"><span class="align-self-center">&nbsp;English</span></a>
                <a class="dropdown-item dropdown-item-tab d-flex adynamic-language p-language span-responsive mt-2 ${'<?=$Language?>' == 'cn' ? 'hidden' : ''}" data-lang="cn" href="#"><span class="align-self-center">&nbsp;中文</span></a>
            </div>
            <a href="#" class="roll-nav roll-nav-last" style="right: 35px !important;" id="userProfileDropdown0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="badge badge-success badge-notification badge-message"></span>
            </a>
            <div class="dropdown-menu position-absolute dropdown-notification" aria-labelledby="userProfileDropdown0">
                <div class="drodpown-title drodpown-title-tab message">
                    <h6 class="d-flex justify-content-between"><span class="align-self-center">${setLanguage('Notification')}</span></h6>
                </div>
                <div class="notification-scroll notification-scroll-tab ps ps--active-y div_Notification_List" style="overflow: auto !important;">
                </div>
            </div>
            <a href="#" class="roll-nav roll-nav-last" style="right: 0px !important;" id="userProfileDropdown1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
            <div class="dropdown-menu position-absolute dropdown-tab" aria-labelledby="userProfileDropdown1">
                <div class="user-profile-section user-profile-tab">
                    <div class="media mx-auto media-tab">
                        <div class="emoji me-2 emoji-tab">👋</div>
                        <div class="media-body media-body-tab">
                            <h5 class="h5-tab" style="font-size: 1.25rem;"><?=$_SESSION['Username']?></h5>
                            <p class="p-tab"><?=$ISGlobalLang['Administrator']?></p>
                        </div>
                    </div>
                </div>
                <div class="dropdown-item dropdown-item-tab">
                    <a class="a-tab" href="user-profile.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span>Profile</span>
                    </a>
                </div>
                <div class="dropdown-item dropdown-item-tab">
                    <a class="a-tab" href="app-mailbox.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span>Inbox</span>
                    </a>
                </div>
                <div class="dropdown-item dropdown-item-tab">
                    <a class="a-tab" href="auth-boxed-lockscreen.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> <span>Lock Screen</span>
                    </a>
                </div>
                <div class="dropdown-item dropdown-item-tab">
                    <a class="a-tab" href="session/logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="tab-content" style="margin-top:5px;"></div>`;
        var run = function(){
            nthTabs.html(template);
            event.onWindowsResize().onTabClose().onTabRollLeft().onTabRollRight().onTabList().onDivTabList()
                .onTabCloseOpt().onTabCloseAll().onTabCloseOther().onLocationTab().onTabToggle();
            return methods;
        };
        var methods = {

            getAllTabWidth: function () {
                var sum_width = 0;
                nthTabs.find('.nav-tabs li').each(function () {
                    sum_width += parseFloat($(this).width());
                });
                return sum_width;
            },

            getMarginStep: function () {
                return settings.rollWidth / 2;
            },

            getActiveId: function () {
                return nthTabs.find('li[class="active"]').find("a").attr("href").replace('#', '');
            },

            getTabList: function () {
                var tabList = [];
                var ListData = nthTabs.find('.nav-tabs li a');
                ListData.each(function () {
                    tabList.push({id: $(this).attr('href'), title: $(this).parent().attr('title'), origModule: $(this).parent().attr('origModule'),content: $(this).parent().attr('content'), dataID : $(this).attr('dataID'), allowCloseClass : $(this).parent().attr('allowCloseClass')});
                });
                return tabList;
            },

            addTab: function (options) {
                var tab = [];
                var optionsTag = [];
                var active = options.active == undefined ? settings.active : options.active;
                var allowClose = options.allowClose == undefined ? settings.allowClose : options.allowClose;
                var origModule = options.origModule == undefined ? settings.origModule : options.origModule;
                var content = options.url;
                var location = options.location == undefined ? settings.location : options.location;
                var fadeIn = options.fadeIn == undefined ? settings.fadeIn : options.fadeIn;
                var allowCloseClass = (allowClose) ? '1' : '0';
                var url = options.url == undefined ? "" : options.url;
                var title = options.origModule.split('/');
                var title1 = '<span class="span-lang tab-label-01">' + setLanguage($.trim(title[0])) + '</span>';
                var title2 = '<span class="span-lang tab-label-02" style="color:#009688">' + setLanguage($.trim(title[1])) + '</span>';
                var title3 = title1 + "<br>" + title2;
                var titleMobile = title1 + " / " + title2;
                var TitleText = setLanguage($.trim(title[0]))+ ' / ' + setLanguage($.trim(title[1]));
                var TabID = options.id.split('-');
                var LongID = TabID[2];

                tab.push('<li content="'+content+'" allowCloseClass="'+allowCloseClass+'" data-id="'+ options.id +'" origModule="'+ origModule +'" title="' + TitleText + '" '+(allowClose ? '' : 'not-allow-close')+'>');
                tab.push('<a style="cursor: pointer!important;" dataID="'+LongID+'" class="anchor-tab" href="#' + options.id + '" data-toggle="tab">');
                tab.push(title3);
                tab.push('</a>');
                allowClose ? tab.push('<i class="icon nth-icon-close-mini tab-close"></i>') : '';
                tab.push('</li>');
                nthTabs.find(".nav-tabs").append(tab.join(''));

                /* --- Sort During Add Tab --*/
                var ArrObj = groupBy(this.getTabList(), "dataID");
                var newArray = [];
                for (var key in ArrObj) {
                    if (!ArrObj.hasOwnProperty(key)) continue;
                    var obj = ArrObj[key];
                    for (var prop in obj) {
                        if (!obj.hasOwnProperty(prop)) continue;
                        newArray.push(obj[prop]);
                    }
                }

                var newTab = [];
                var newTabMobile = [];
                for (var key in newArray) {
                    if (newArray.hasOwnProperty(key)) {
                        var title = newArray[key]['origModule'].split('/');
                        var title1 = '<span class="span-lang tab-label-01 hidden" style="color:#FFF">' + setLanguage($.trim(title[0])) + '</span>';
                        var title2 = '<span class="span-lang tab-label-02" style="color:#FFF">' + setLanguage($.trim(title[1])) + '</span>';
                        var title3 = title1 + " " + title2;
                        var titleMobile = title1 + " / " + title2;
                        var TitleText = setLanguage($.trim(title[0]))+ ' / ' + setLanguage($.trim(title[1]));
                        var TabID = newArray[key]['id'].split('-');
                        var LongID = TabID[2];
                        newTab.push('<li content="'+newArray[key]['content']+'" allowCloseClass="'+newArray[key]['allowCloseClass']+'" data-id="'+ newArray[key]['dataID'] +'" origModule="'+ newArray[key]['origModule'] +'" title="' + TitleText + '" '+(allowClose ? '' : 'not-allow-close')+'>');
                        newTab.push('<a style="cursor: pointer!important;" dataID="'+LongID+'" class="anchor-tab" href="' + newArray[key]['id'] + '" data-toggle="tab">');
                        newTab.push(title3);
                        newTab.push('</a>');
                        newArray[key]['allowCloseClass'] == '1' ? newTab.push('<i class="icon nth-icon-close-mini tab-close"></i>') : '';
                        newTab.push('</li>');
                    }
                }
                nthTabs.find(".nav-tabs").empty().append(newTab.join(''));
                /* --- END Sort During Add Tab --*/
                // TAB-CONTENT
                var tabContent = [];
                tabContent.push('<div class="tab-pane '+(fadeIn ? 'animation-fade' : '')+'" id="' + options.id  +'" '+(allowClose ? '' : 'not-allow-close')+'>');
                if(url.length>0){
                    tabContent.push('<iframe id="iframe'+LongID+'" style="height:'+iframeHeight+'px" src="'+options.url+'" frameborder="0" name="iframe-'+frameName+'" class="nth-tabs-frame"></iframe>');

                }else{
                    tabContent.push('<div class="nth-tabs-content">'+options.content+"</div>");
                }
                tabContent.push('</div>');
                nthTabs.find(".tab-content").append(tabContent.join(''));
                active && this.setActTab(options.id);
                location && this.locationTab(options.id);
                frameName++;
                return this;
            },
   
            addTabs: function (tabsOptions) {
                for(var index in tabsOptions){
                    this.addTab(tabsOptions[index]);
                }
                return this;
            },

            locationTab: function (tabId) {
                tabId = tabId == undefined ? methods.getActiveId() : tabId;
                tabId = tabId.indexOf('#') > -1 ? tabId : '#' + tabId;
                var navTabOpt = nthTabs.find("[href='" + tabId + "']");
                var beforeTabsWidth = 0;
                navTabOpt.parent().prevAll().each(function () {
                    beforeTabsWidth += $(this).width();
                });
                var contentTab = navTabOpt.parent().parent().parent();
                if (beforeTabsWidth <= settings.rollWidth) {
                    margin_left_total = 40;
                }
                else{
                    margin_left_total = 40 - Math.floor(beforeTabsWidth / settings.rollWidth) * settings.rollWidth;
                }
                contentTab.css("margin-left", margin_left_total);
                return this;
            },

            delTab: function (tabId) {
                tabId = tabId == undefined ? methods.getActiveId() : tabId;
                tabId = tabId.indexOf('#') > -1 ? tabId : '#' + tabId;
                var navTabA = nthTabs.find("[href='" + tabId + "']");
                var activeID = 0;
                if(navTabA.parent().attr('not-allow-close')!=undefined) return false;
                if (navTabA.parent().attr('class') == 'active') {
                    var activeNavTab = navTabA.parent().next();
                    var activeTabContent = $(tabId).next();
                    if (activeNavTab.length < 1) {
                        activeNavTab = navTabA.parent().prev();
                        activeTabContent = $(tabId).prev();
                    }
                    activeNavTab.addClass('active');
                    activeTabContent.addClass('active');
                    activeID = activeTabContent.attr('id');
                }
                navTabA.parent().remove();
                $(tabId).remove();
                return this;
            },

            delOtherTab: function () {
                nthTabs.find(".nav-tabs li").not('[class="active"]').not('[not-allow-close]').remove();
                nthTabs.find(".tab-content div.tab-pane").not('[not-allow-close]').not('[class$="active"]').remove();
                nthTabs.find('.content-tabs-container').css("margin-left", 40);
                return this;
            },
            delAllTab: function () {
                this.delOtherTab();
                this.delTab();
                return this;
            },
            setActTab: function (tabId) {
                console.log(tabId);
                tabId = tabId == undefined ? methods.getActiveId() : tabId;
                tabId = tabId.indexOf('#') > -1 ? tabId : '#' + tabId;
                nthTabs.find('.active').removeClass('active');
                nthTabs.find("[href='" + tabId + "']").parent().addClass('active');
                nthTabs.find(tabId).addClass('active');
                return this;
            },
            toggleTab: function (tabId) {
                this.setActTab(tabId).locationTab(tabId);
                return this;
            },
            isExistsTab: function (tabId) {
                tabId = tabId.indexOf('#') > -1 ? tabId : '#' + tabId;
                return nthTabs.find(tabId).length>0;
            },
            tabToggleHandler: function(func){
                handler["tabToggleHandler"] = func;
            }
        };

        var event = {
            onWindowsResize: function () {
                $(window).resize(function () {
                    settings.rollWidth = nthTabs.width() - 120;
                });
                return this;
            },
            onLocationTab: function () {
                nthTabs.on("click", '.tab-location', function () {
                    methods.locationTab();
                });
                return this;
            },
            onTabClose: function () {
                nthTabs.on("click", '.tab-close', function () {
                    var iBody = $("iframe").contents().find("body");
                    var tabId = $(this).parent().find("a").attr('href');
                    var navTabOpt = nthTabs.find("[href='" + tabId + "']");
                    if(navTabOpt.parent().next().length == 0){
                        var beforeTabsWidth = 0;
                        navTabOpt.parent().prevAll().each(function () {
                            beforeTabsWidth += $(this).width();
                        });
                        var optTabWidth = navTabOpt.parent().width();
                        var margin_left_total = 40;
                        var contentTab = navTabOpt.parent().parent().parent();
                        if (beforeTabsWidth > settings.rollWidth) {
                            var margin_left_origin = contentTab.css('marginLeft').replace('px', '');
                            margin_left_total = parseFloat(margin_left_origin) + optTabWidth + 40;
                        }
                        contentTab.css("margin-left", margin_left_total);
                    }
                    methods.delTab(tabId);
                    var contentID = tabId.substring(1);
                    var globID='';
                    $(".ul-dynamic-tab li").each(function(){
                        if ($(this).hasClass('active')){
                            var ParentTab = $(this).attr('origModule');
                            var lastTitle = ParentTab.split('/');
                            var id = $(this).find('a').attr('href');
                            var id = id.substring(1);
                            globID = id;
                        }
                    });
                    var href = '#'+globID;
                    if(globID == 'nth-tab-1470969182499-0'){
                        $(".ul-dynamic-tab li").find('a[href="'+href+'"]').get(0).click();
                    }

                    var tabLiArray = [];
                    var indexCount = 0;
                    var $tab_Li = $('body').find('.ul-dynamic-tab li');
                    var $tabl_len = $tab_Li.length;
                    $tab_Li.each(function(){
                        var content = $(this).attr('content');
                        var content_id = $(this).find('a').attr('href');
                        var orig_module = $(this).attr('origmodule'); 
                        var title = $(this).attr('title');
                        var EmployeeID = $("#HeaderEmployeeID").attr('dataVal');
                        var machine_id = $("#HeaderEmployeeID").attr('dataSessionID');
                        var active = 0;
                        if($(this).hasClass('active')){
                            active = 1;
                        }
                        if(indexCount != 0){
                            tabLiArray.push({
                                content : content,
                                content_id : content_id.substring(1, content_id.length),
                                orig_module : orig_module,
                                title : title,
                                EmployeeID : EmployeeID,
                                machine_id : machine_id,
                                active : active,
                            });
                        }
                        indexCount++;
                    });
                    $.ajax({
                        method: "POST",
                        url: "cookies/set_cookies2.php",
                        data : {tabLiArray}
                    }).done(function( msg ) {
                        if (msg == 1){
                            console.log('Reset Session');
                        }
                    });
                    setTimeout(() => window.dispatchEvent(new Event('resize')), 200);
                });
                return this;
            },

            onTabCloseOpt: function () {
                nthTabs.on("click", '.tab-close-current', function () {
                    methods.delTab();
                });
                return this;
            },

            onTabCloseOther: function () {
                nthTabs.on("click", '.tab-close-other', function () {
                    methods.delOtherTab();
                });
                return this;
            },

            onTabCloseAll: function () {
                nthTabs.on("click", '.tab-close-all', function () {
                    methods.delAllTab();
                });
                return this;
            },

            onTabRollLeft: function () {
                nthTabs.on("click", '.roll-nav-left', function () {
                    var contentTab = $(this).parent().find('.content-tabs-container');
                    var margin_left_total;
                    if (methods.getAllTabWidth() <= settings.rollWidth) {
                        margin_left_total = 40;
                    }else{
                        var margin_left_origin = contentTab.css('marginLeft').replace('px', '');
                        margin_left_total = parseFloat(margin_left_origin) + methods.getMarginStep() + 40;
                    }
                    contentTab.css("margin-left", margin_left_total > 40 ? 40 : margin_left_total);
                });
                return this;
            },

            onTabRollRight: function () {
                nthTabs.on("click", '.roll-nav-right', function () {
                    if (methods.getAllTabWidth() <= settings.rollWidth) return false;
                    var contentTab = $(this).parent().find('.content-tabs-container');
                    var margin_left_origin = contentTab.css('marginLeft').replace('px', '');
                    var margin_left_total = parseFloat(margin_left_origin) - methods.getMarginStep();
                    if (methods.getAllTabWidth() - Math.abs(margin_left_origin) <= settings.rollWidth) return false;
                    contentTab.css("margin-left", margin_left_total);
                });
                return this;
            },
            onTabList: function () {
                nthTabs.on("click", '.right-nav-list', function () {
                    var tabList = methods.getTabList();
                    var html = [];
                    $.each(tabList, function (key, val) {
                        var title = val.origModule.split('/');
                        var title1 = '<span class="span-lang">' +  setLanguage($.trim(title[0])) + '</span>';
                        var title2 = '<span class="span-lang">' +  setLanguage($.trim(title[1])) + '</span>';
                        var title3 = title1 + ' / ' + title2;

                        html.push('<li class="toggle-tab" data-id="' + val.id + '">' + title3 + '</li>');
                    });
                    nthTabs.find(".tab-list").html(html.join(''));
                });
                nthTabs.find(".tab-list-scrollbar").scrollbar();
                this.onTabListToggle();
                return this;
            },
            onDivTabList: function () {
                nthTabs.on("click", '#modalBtnOptsTabs', function () {
                    if($("body").find("#modalOptTabs").hasClass("hide")){
                        $("body").find("#modalOptTabs").show();
                        $("body").find("#modalOptTabs").removeClass("hide").addClass("show");
                    }
                    else{
                        $("body").find("#modalOptTabs").hide();
                        $("body").find("#modalOptTabs").removeClass("show").addClass("hide");
                    }
                });
                return this;
            },
            onTabListToggle: function () {
                nthTabs.on("click", '.toggle-tab', function () {
                    var tabId = $(this).data("id");
                    methods.setActTab(tabId).locationTab(tabId);
                });
                nthTabs.on('click','.scroll-element',function (e) {
                    e.stopPropagation();
                });
                return this;
            },
            onTabToggle: function(){
                nthTabs.on("click", '.nav-tabs li', function () {
                    var lastTabText = nthTabs.find(".nav-tabs li a[href='#"+methods.getActiveId()+"'] span").text();
                    $( this ).parent().find( 'li.active' ).removeClass( 'active' );
                    $( this ).addClass( 'active' );

                    var id = $(this).find('a').attr('href');
                    var id = id.substring(1);
                    handler["tabToggleHandler"]({
                        last:{
                            tabId:methods.getActiveId(),
                            tabText:lastTabText
                        },
                        active:{
                            tabId:$(this).find("a").attr("href").replace('#',''),
                            tabText:$(this).find("a span").text()
                        }
                    });
                });
               
            }
        };
        return run();
    }
    function groupBy(collection, property) {
        var i = 0, val, index,
            values = [], result = [];
        for (; i < collection.length; i++) {
            val = collection[i][property];
            index = values.indexOf(val);
            if (index > -1)
                result[index].push(collection[i]);
            else {
                values.push(val);
                result.push([collection[i]]);
            }
        }
        return result;
    }
})(jQuery);
</script>