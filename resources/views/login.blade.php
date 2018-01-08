<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="{{csrf_token()}}" id="csrf_token" name="csrf"/>
    <title>
        {{config("app.name")}}
    </title>
    <style type="text/css">
        html {
            height: 100%;
        }
        body {
            font-family: "Microsoft Yahei";
            background-color: #2f4050;
            padding: 0;
            margin: 0;
            font-size: 14px;
            height: 100%;
        }

        .xheader {
            border-bottom: 1px solid #2f4050;
            background-color: rgba(0, 0, 0, 0.3);
            width: 100%;
            padding: 10px;
            color: #FFF;
            position: fixed;
            font-size: 18px;
        }

        .main_box {
            position: absolute;
            right: 50%;
            left: 50%;
            margin-left: -170px;

        }

        #login_account {
            background-color: rgba(0,0,0,0);
            width: 480px;
            height: 320px;
            padding: 20px;
            /*margin: 50px auto;*/
            position: fixed;
            left: 50%;
            top: 45%;
            margin-top: -170px;
            margin-left: -250px;
        }

        #login_account input {
            width: 220px;
            height: 32px;
            margin-bottom: 10px;
            border: 1px solid #999;
            padding-left: 32px;
            color: #666;
            font-size: 14px;
        }

        #login_account #account {
            background: url("/img/icon-user.png") no-repeat;
            background-size: 20px;
            background-position: 2% 50%;
        }

        #login_account #pwd {
            background: url("/img/icon-pwd.png") no-repeat;
            background-size: 20px;
            background-position: 2% 50%;
            margin-top: 5px;
        }

        #login_account .submit {
            display: inline-block;
            text-align: center;
            width: 255px;
            height: 42px;
            border-radius: 6px;
            margin-top: 30px;
            border: 0px;
            cursor: pointer;
            font-size: 16px;
            color: #2f4050;
            border: solid 1px #2f4050;
            /*opacity : 0.1;*/
        }

        #login_account .submit:hover {
            background: #E85515;
            color: #fff;
            border: solid 1px #E85515;
        }

        #login_account .btnClose {
            width: 25px;
            height: 25px;
            background: #fff;
            border: solid 1px #999;
            border-top: none;
            color: #666;
            position: absolute;
            top: 0;
            right: 10px;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
        }

        #login_account .btnClose:hover, .login-loading {
            border: solid 1px #E85515;
            border-top: none;
            color: #fff;
            background: #E85515;
        }

        .tips {
            margin-top: 10px;
            display: block;
            color: red;
        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            font-size: 12px;
            text-align: center;
            color: #ddd;
        }

        .footer a {
            text-decoration: none;
            color: #ddd;
            padding: 0 5px;
        }

        .footer a:hover {
            color: #FC611F;
        }
    </style>
    <style>
        body {
            background-color: #dedede;
            font-size: 12px;
        }

        .base {
            height: 9em;
            left: 50%;
            margin: -7.5em;
            padding: 3em;
            position: absolute;
            top: 65%;
            width: 9em;
            transform: rotateX(45deg) rotateZ(45deg);
            transform-style: preserve-3d;
        }

        .cube,
        .cube:after,
        .cube:before {
            content: '';
            float: left;
            height: 3em;
            position: absolute;
            width: 3em;
        }

        /* Top */
        .cube {
            background-color: #05afd1;
            position: relative;
            transform: translateZ(3em);
            transform-style: preserve-3d;
            transition: .25s;
            box-shadow: 13em 13em 1.5em rgba(0, 0, 0, 0.1);
            animation: anim 1s infinite;
        }
        .cube:after {
            background-color: #049dbc;
            transform: rotateX(-90deg) translateY(3em);
            transform-origin: 100% 100%;
        }
        .cube:before {
            background-color: #048ca7;
            transform: rotateY(90deg) translateX(3em);
            transform-origin: 100% 0;
        }
        .cube:nth-child(1) {
            animation-delay: 0.05s;
        }
        .cube:nth-child(2) {
            animation-delay: 0.1s;
        }
        .cube:nth-child(3) {
            animation-delay: 0.15s;
        }
        .cube:nth-child(4) {
            animation-delay: 0.2s;
        }
        .cube:nth-child(5) {
            animation-delay: 0.25s;
        }
        .cube:nth-child(6) {
            animation-delay: 0.3s;
        }
        .cube:nth-child(7) {
            animation-delay: 0.35s;
        }
        .cube:nth-child(8) {
            animation-delay: 0.4s;
        }
        .cube:nth-child(9) {
            animation-delay: 0.45s;
        }

        @keyframes anim {
            50% {
                transform: translateZ(0.5em);
            }
        }

    </style>
    <script>
        /**
         * StyleFix 1.0.3 & PrefixFree 1.0.7
         * @author Lea Verou
         * MIT license
         */
        (function(){function t(e,t){return[].slice.call((t||document).querySelectorAll(e))}if(!window.addEventListener)return;var e=window.StyleFix={link:function(t){try{if(t.rel!=="stylesheet"||t.hasAttribute("data-noprefix"))return}catch(n){return}var r=t.href||t.getAttribute("data-href"),i=r.replace(/[^\/]+$/,""),s=(/^[a-z]{3,10}:/.exec(i)||[""])[0],o=(/^[a-z]{3,10}:\/\/[^\/]+/.exec(i)||[""])[0],u=/^([^?]*)\??/.exec(r)[1],a=t.parentNode,f=new XMLHttpRequest,l;f.onreadystatechange=function(){f.readyState===4&&l()},l=function(){var n=f.responseText;if(n&&t.parentNode&&(!f.status||f.status<400||f.status>600)){n=e.fix(n,!0,t);if(i){n=n.replace(/url\(\s*?((?:"|')?)(.+?)\1\s*?\)/gi,function(e,t,n){return/^([a-z]{3,10}:|#)/i.test(n)?e:/^\/\//.test(n)?'url("'+s+n+'")':/^\//.test(n)?'url("'+o+n+'")':/^\?/.test(n)?'url("'+u+n+'")':'url("'+i+n+'")'});var r=i.replace(/([\\\^\$*+[\]?{}.=!:(|)])/g,"\\$1");n=n.replace(RegExp("\\b(behavior:\\s*?url\\('?\"?)"+r,"gi"),"$1")}var l=document.createElement("style");l.textContent=n,l.media=t.media,l.disabled=t.disabled,l.setAttribute("data-href",t.getAttribute("href")),a.insertBefore(l,t),a.removeChild(t),l.media=t.media}};try{f.open("GET",r),f.send(null)}catch(n){typeof XDomainRequest!="undefined"&&(f=new XDomainRequest,f.onerror=f.onprogress=function(){},f.onload=l,f.open("GET",r),f.send(null))}t.setAttribute("data-inprogress","")},styleElement:function(t){if(t.hasAttribute("data-noprefix"))return;var n=t.disabled;t.textContent=e.fix(t.textContent,!0,t),t.disabled=n},styleAttribute:function(t){var n=t.getAttribute("style");n=e.fix(n,!1,t),t.setAttribute("style",n)},process:function(){t("style").forEach(StyleFix.styleElement),t("[style]").forEach(StyleFix.styleAttribute)},register:function(t,n){(e.fixers=e.fixers||[]).splice(n===undefined?e.fixers.length:n,0,t)},fix:function(t,n,r){for(var i=0;i<e.fixers.length;i++)t=e.fixers[i](t,n,r)||t;return t},camelCase:function(e){return e.replace(/-([a-z])/g,function(e,t){return t.toUpperCase()}).replace("-","")},deCamelCase:function(e){return e.replace(/[A-Z]/g,function(e){return"-"+e.toLowerCase()})}};(function(){setTimeout(function(){},10),document.addEventListener("DOMContentLoaded",StyleFix.process,!1)})()})(),function(e){function t(e,t,r,i,s){e=n[e];if(e.length){var o=RegExp(t+"("+e.join("|")+")"+r,"gi");s=s.replace(o,i)}return s}if(!window.StyleFix||!window.getComputedStyle)return;var n=window.PrefixFree={prefixCSS:function(e,r,i){var s=n.prefix;n.functions.indexOf("linear-gradient")>-1&&(e=e.replace(/(\s|:|,)(repeating-)?linear-gradient\(\s*(-?\d*\.?\d*)deg/ig,function(e,t,n,r){return t+(n||"")+"linear-gradient("+(90-r)+"deg"})),e=t("functions","(\\s|:|,)","\\s*\\(","$1"+s+"$2(",e),e=t("keywords","(\\s|:)","(\\s|;|\\}|$)","$1"+s+"$2$3",e),e=t("properties","(^|\\{|\\s|;)","\\s*:","$1"+s+"$2:",e);if(n.properties.length){var o=RegExp("\\b("+n.properties.join("|")+")(?!:)","gi");e=t("valueProperties","\\b",":(.+?);",function(e){return e.replace(o,s+"$1")},e)}return r&&(e=t("selectors","","\\b",n.prefixSelector,e),e=t("atrules","@","\\b","@"+s+"$1",e)),e=e.replace(RegExp("-"+s,"g"),"-"),e=e.replace(/-\*-(?=[a-z]+)/gi,n.prefix),e},property:function(e){return(n.properties.indexOf(e)?n.prefix:"")+e},value:function(e,r){return e=t("functions","(^|\\s|,)","\\s*\\(","$1"+n.prefix+"$2(",e),e=t("keywords","(^|\\s)","(\\s|$)","$1"+n.prefix+"$2$3",e),e},prefixSelector:function(e){return e.replace(/^:{1,2}/,function(e){return e+n.prefix})},prefixProperty:function(e,t){var r=n.prefix+e;return t?StyleFix.camelCase(r):r}};(function(){var e={},t=[],r={},i=getComputedStyle(document.documentElement,null),s=document.createElement("div").style,o=function(n){if(n.charAt(0)==="-"){t.push(n);var r=n.split("-"),i=r[1];e[i]=++e[i]||1;while(r.length>3){r.pop();var s=r.join("-");u(s)&&t.indexOf(s)===-1&&t.push(s)}}},u=function(e){return StyleFix.camelCase(e)in s};if(i.length>0)for(var a=0;a<i.length;a++)o(i[a]);else for(var f in i)o(StyleFix.deCamelCase(f));var l={uses:0};for(var c in e){var h=e[c];l.uses<h&&(l={prefix:c,uses:h})}n.prefix="-"+l.prefix+"-",n.Prefix=StyleFix.camelCase(n.prefix),n.properties=[];for(var a=0;a<t.length;a++){var f=t[a];if(f.indexOf(n.prefix)===0){var p=f.slice(n.prefix.length);u(p)||n.properties.push(p)}}n.Prefix=="Ms"&&!("transform"in s)&&!("MsTransform"in s)&&"msTransform"in s&&n.properties.push("transform","transform-origin"),n.properties.sort()})(),function(){function i(e,t){return r[t]="",r[t]=e,!!r[t]}var e={"linear-gradient":{property:"backgroundImage",params:"red, teal"},calc:{property:"width",params:"1px + 5%"},element:{property:"backgroundImage",params:"#foo"},"cross-fade":{property:"backgroundImage",params:"url(a.png), url(b.png), 50%"}};e["repeating-linear-gradient"]=e["repeating-radial-gradient"]=e["radial-gradient"]=e["linear-gradient"];var t={initial:"color","zoom-in":"cursor","zoom-out":"cursor",box:"display",flexbox:"display","inline-flexbox":"display",flex:"display","inline-flex":"display",grid:"display","inline-grid":"display","min-content":"width"};n.functions=[],n.keywords=[];var r=document.createElement("div").style;for(var s in e){var o=e[s],u=o.property,a=s+"("+o.params+")";!i(a,u)&&i(n.prefix+a,u)&&n.functions.push(s)}for(var f in t){var u=t[f];!i(f,u)&&i(n.prefix+f,u)&&n.keywords.push(f)}}(),function(){function s(e){return i.textContent=e+"{}",!!i.sheet.cssRules.length}var t={":read-only":null,":read-write":null,":any-link":null,"::selection":null},r={keyframes:"name",viewport:null,document:'regexp(".")'};n.selectors=[],n.atrules=[];var i=e.appendChild(document.createElement("style"));for(var o in t){var u=o+(t[o]?"("+t[o]+")":"");!s(u)&&s(n.prefixSelector(u))&&n.selectors.push(o)}for(var a in r){var u=a+" "+(r[a]||"");!s("@"+u)&&s("@"+n.prefix+u)&&n.atrules.push(a)}e.removeChild(i)}(),n.valueProperties=["transition","transition-property"],e.className+=" "+n.prefix,StyleFix.register(n.prefixCSS)}(document.documentElement);

    </script>
</head>
<body id="particles-js">
<div class="xheader">
    {{config("app.name")}}
</div>

<div class="main_box">
    <div id="login_account">
        <div style="text-align: center;">

            <input id="account" class="input-login" placeholder="用户名" type="text"/>
            <input id="pwd" class="input-login" placeholder="密码" type="password"/>

            <button class="submit">
                登录
            </button>
            <p class="tips">
            </p>
        </div>
    </div>
</div>
<div class='base'>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
    <div class='cube'></div>
</div>
<div class="footer">
    {{--<a target="_blank" href="http://gammainfo.com">@技术支持 特觅科</a>--}}
</div>

</body>
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js">
</script>
<script src="js/particles/particles.min.js"></script>
<script src="js/particles/app.js"></script>
<script type="text/javascript">
    $(function () {

        // var guid = '';
        var status = 0;
        var ajaxRequest = null;
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });
        $(".submit").on("click", function () {
            var _n = $.trim($("#account").val());
            var _p = $.trim($("#pwd").val());
            if (_n == "" || _p == "") {
                $(".tips").html("帐号或密码为空");
                return;
            }
            var self = $(this);
            if (self.hasClass('login-loading')) {
                return;
            }
            self.addClass('login-loading');
            self.text('正在登录...');
            $.post("/login", {name: _n, pass: _p}, function (response) {
                console.log(response)
                if (response.status == 0) {
                    window.location.href = "/";
                } else {
                    $(".tips").html("帐号或密码错误");
                }
            }).always(function () {
                self.text('登录');
                self.removeClass('login-loading');
            });
        })
        $('.input-login').keydown(function () {
            $('.tips').text('');
            if (event.keyCode == "13") {
                $('.submit').trigger('click');
            }
        });

    });
</script>
</html>
