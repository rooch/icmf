<?php 
$settings = array();

/*###########################
#         Data base         #
###########################*/
$settings['type'] = "mysql";
$settings['host'] = "localhost";
$settings['user'] = "root";
$settings['pass'] = "jyu88y";
$settings['name'] = "icmf";
$settings['tablePrefix'] = "";

/* Table Names */
$settings['access'] = "access";                    
$settings['badWord'] = "badWord";
$settings['basketObject'] = "basketObject";
$settings['bugReport'] = "bugReport";
$settings['city'] = "city";
$settings['commentObject'] = "commentObject";
$settings['company'] = "company";
$settings['contactBook'] = "contactBook";
$settings['contactMessage'] = "contactMessage";
$settings['countries'] = "countries";
$settings['creditCategory'] = "creditCategory";
$settings['creditObject'] = "creditObject";
$settings['district'] = "district";
$settings['distance'] = "distance";
$settings['eDeliveryObject'] = "eDeliveryObject";
$settings['eDeliveryType'] = "eDeliveryType";
$settings['eduBranch'] = "eduBranch";
$settings['financialBank'] = "financialBank";
$settings['financialInvoice'] = "financialInvoice";
$settings['financialTransaction'] = "financialTransaction";
$settings['financialTransactionType'] = "financialTransactionType";
$settings['formsEntity'] = "formsEntity";
$settings['formsFields'] = "formsFields";
$settings['galleryCategory'] = 'galleryCategory';
$settings['galleryObject'] = 'galleryObject';
$settings['gender'] = "gender";
$settings['groupManMembers'] = "groupManMembers";
$settings['groupManObject'] = "groupManObject";
$settings['helpDeskEntity'] = "helpDeskEntity";
$settings['jobTitle'] = "jobTitle";
$settings['lang'] = "lang";
$settings['langCode'] = "langCode";
$settings['level'] = "level";
$settings['libraryCategory'] = "libraryCategory";
$settings['libraryFavorite'] = "libraryFavorite";
$settings['libraryObject'] = "libraryObject";
$settings['mtaLog'] = "mtaLog";
$settings['mtaQueue'] = "mtaQueue";
$settings['mtaSmtp'] = "mtaSmtp";
$settings['menu'] = "menu";
$settings['payPerClickCategory'] = "payPerClickCategory";
$settings['payPerClickObject'] = "payPerClickObject";
$settings['pollEntity'] = "pollEntity";
$settings['pollStat'] = "pollStat";
$settings['post'] = "post";
$settings['postCategory'] = "postCategory";
$settings['postObject'] = "postObject";
$settings['productCategory'] = "productCategory";
$settings['productObject'] = "productObject";
$settings['productObjectExtraFields'] = "productObjectExtraFields";
$settings['region'] = "region";
$settings['religion'] = "religion";
$settings['seo'] = "seo";
$settings['session'] = "session";
$settings['shopCategory'] = "shopCategory";
$settings['shopObject'] = "shopObject";
$settings['smsCategory'] = "smsCategory";
$settings['smsObject'] = "smsObject";
$settings['state'] = "state";
$settings['status'] = "status";
$settings['task'] = "task";
$settings['taskLog'] = "taskLog";
$settings['trustUrl'] = "trustUrl";
//$settings['user'] = "user";
$settings['userExtraInfo'] = "userExtraInfo";
$settings['userSettings'] = "userSettings";
$settings['watchDog'] = "watchDog";


/*###########################
#         Addresses         #
###########################*/
$settings['kernelAddress'] = "kernel";
$settings['controllerAddress'] = "kernel/controller";
$settings['moduleController'] = "controller";
$settings['modelAddress'] = "model";
$settings['viewAddress'] = "view";
$settings['tplAddress'] = "tpl";
$settings['libraryAddress'] = "kernel/lib";
$settings['phpThumbLibraryAddress'] = "kernel/lib/xorg/phpThumb";
$settings['langAddress'] = "lang";
$settings['themeAddress'] = "theme";
$settings['docAddress'] = "doc";
$settings['moduleAddress'] = "module";
$settings['homeAddress'] = "home";
$settings['envAddress'] = "env";

/*###########################
#        Extentions         #
###########################*/
$settings['ext1'] = ".pom";
$settings['ext2'] = ".php";
$settings['ext3'] = ".txt";
$settings['ext4'] = ".htm";
$settings['ext5'] = ".tpl";

/*###########################
#        Information        #
###########################*/
$settings['siteName'] = "برند ساز";
$settings['websiteTitle'] = "شتاب دهنده کسب و کار و تجارت الکترونیک";
$settings['domainName'] = "icmf.com";
$settings['packageName'] = "icmf";
$settings['trailerAddress'] = "modam/html/";
$settings['fullAddress'] = $settings['domainName'] . "/" . $settings['trailerAddress'];
$settings['version'] = "0.7.0.8";
$settings['keyWords'] = "کسب و کار,تجارت الکترونیک,کسب و کار الکترونیک,کسب و کار اینترنتی,کسب و کار کوچک,وب سایت,بازاریابی الکترونیکی,استارت آپ,شتاب دهنده کسب و کار,کار آفرینی,فروش اینترنتی,فروشگاه اینترنتی";
$settings['author'] = "Faragamane Sharif Co";
$settings['authorWebsite'] = "http://www.faragamane-sharif.com";
$settings['googleAuthor'] = 'https://plus.google.com/117322159911789307947';
$settings['googlePublisher'] = 'https://plus.google.com/117322159911789307947';
$settings['twitterPublisher'] = 'digiseo_ir';
$settings['facebookAdminID'] = '1276715910';
$settings['description'] = "ما به عنوان شتاب دهنده کار آفرینی و کسب و کار در قالب تجارت الکترونیک، این امکان را بوجود می آوریم که مردم ایده های خود را بدون درگیر شدن با مسائل فنی، به کسب و کار الکترونیکی تبدیل نموده و درآمد کسب کنند.";
$settings['robots'] = "ALL"; // ALL | NONE | INDEX | NOINDEX | FOLLOW | NOFOLLOW
$settings['copyright'] = "کلیه حقوق این سایت برای $settings[author] می باشد.";

/*###########################
#           Pass            #
###########################*/
$settings['passLenght'] = 6;
$settings['userLenght'] = 6;

/*###########################
#           Mail            #
###########################*/
$settings['adminMail'] = "admin@" . $settings['domainName'];
$settings['invoiceMail'] = "invoice@" . $settings['domainName'];
$settings['infoMail'] = "info@" . $settings['domainName'];
$settings['sellMail'] = "sale@" . $settings['domainName'];
$settings['roboMail'] = "noreplay@" . $settings['domainName'];

/*###########################
#           Lang            #
###########################*/
$settings['lang'] = "1"; //Fa:1, En:2, Fr:3;
$settings['language'] = "fa-ir";

/*###########################
#           Theme           #
###########################*/
$settings['theme'] = "responsive";

/*###########################
#     Sessions & Cookie     #
###########################*/
$settings['sessionTimeOut'] = 180; //Second

/*###########################
#          Static           #
###########################*/
$settings['localTime'] = "+03:30";

/*###########################
#          Static           #
###########################*/
$settings['googleAccount'] = "";
$settings['googleDomainName'] = "";

/*###########################
#          Smarty           #
###########################*/
$settings['commonTpl'] = "theme/$settings[theme]/tpl/common/";
$settings['customiseTpl'] = "theme/$settings[theme]/tpl/customise/";
$settings['cache'] = false; //true or false
$settings['cacheLifeTime'] = 86400;
$settings['cacheDir'] = "tmp/cache";

/*###########################
#          Default          #
###########################*/
$settings['defaultOp'] = "pageLoader";
$settings['defaultMode'] = "v_load";

/*###########################
#           Time            #
###########################*/
$settings['timezone'] = 'Asia/Tehran';

/*###########################
 #         Credit           #
 ###########################*/
$settings['debug'] = false;
?>