

<div id="carousel" class="carousel mb-lg-4 mb-1 bottom-space carousel-fade slide index-banner {if $bannershape neq 'svg'}banner-with-svg{/if}" data-ride="carousel">



    <ul class="carousel-indicators">
        {foreach from=$bannerarray key=id item=banners name=foo}
            <li data-target="#carousel" data-slide-to="{$smarty.foreach.foo.index}" class="{if $banners@first}active{/if}"></li>
        {/foreach}
    </ul>

    <div class="carousel-inner text-center mx-auto">



        {foreach from=$bannerarray key=id item=banners}


            <div class="carousel-item {if $banners@first}active{/if}" style="background:{$banners.data.backgroundColor} {if $banners.data.bg eq 'image'} url('{$banners.data.backgroundImage}') {/if} center;background-size: cover">

                <div class="banner-type {$banners.data.bg} banner{$id}"  {if $banners.data.bg eq 'color'} style="background-color:{$banners.data.backgroundColor}" {/if}>
                    {if $banners.data.bg eq 'image'}
                        <img src="{$banners.data.backgroundImage}" class="image mw-100" />
                    {/if}
                    <div class="position-{if $banners.data.bg eq 'image'}absolute{else}relative{/if}  w-100 h-100 related-parent">
                        <div class="container h-100 p-lg-5">
                            <div class="d-flex  align-items-center h-100 p-lg-5">
                                <div class="w-100 p-5 bottom-space banner-content">
                                    {$banners.info|@html_entity_decode}
                                    {$banners.other_html|@html_entity_decode}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {if $banners.data.bg eq 'svg'}
                    <style>
                        .banner{$id}{
                            background-image: url("{$banners.data.backgroundSVG}");
                            background-size: cover;
                            width:100%;
                        }
                    </style>
                {/if}
                <div class="bg-svg2 d-none d-md-block svg24"></div>
                {if $banners.readmore_link}
                    <a  class="position-absolute related-parent" href="{$banners.readmore_link}" target="_blank"></a>
                {/if}
            </div>
        {/foreach}
    </div>





    {if $bannerarray.length > 1}
        <a class="carousel-control-prev" href="#carousel" data-slide="prev">
            <i class="fal fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next" href="#carousel" data-slide="next">
            <i class="fal fa-chevron-right"></i>
        </a>
    {/if}




    <div class="bg-svg   d-none d-lg-block {if $bannershape} {$bannershape} {/if}"></div>




</div>


{literal}
    <style type="text/css">
        .shapes{display: none}
        .carousel-fade .carousel-item {
            opacity:0;
            transition-duration:.6s;
            transition-property:opacity;
        }
        .carousel-fade .carousel-item img {

        }
        .carousel-fade .carousel-item.active,.carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right {
            opacity:1;
        }
        .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right {
            opacity:0;
        }
        .carousel-fade .carousel-item-next,.carousel-fade .carousel-item-prev,.carousel-fade .carousel-item.active,.carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-prev {
            transform:translateX(0);
            transform:translate3d(0,0,0);
        }
        .carousel-indicators img {
            float: left;
            left: 0;
        }
        .carousel.index-banner{
            background: #ddd;
        }
        .carousel-indicator-img{
            position: relative;
            bottom:0;
        }
        .carousel-indicator-img li{
            width: auto;
            height: auto;
            cursor: pointer;
            background: rgba(0,0,0,0.5) !important;
        }
        .carousel-indicators li.active{
            background: #404040;
        }

        .carousel-indicators .active img {
            border: 1px solid #428BCA;
            opacity: 0.7;
        }

        .carousel-indicators img {
            max-height: 70px;
            max-width: 70px !important;
        }
        .carousel-control-next-icon, .carousel-control-prev-icon {
            background-color: #dbdbdb !important;
        }


        .banner-type.none{
            border-bottom: #ddd solid 1px;
        }
        .banner-type.svg{
            background-size: cover;
        }

        .banner-with-svg .bottom-space{
            margin-bottom:10rem;
        }

        .bg-svg,.bg-svg2{
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .bg-svg.inverse,.bg-svg2.inverse{
            bottom: auto;
            top: 0;

            transform: rotateX(180deg);
        }


        .svg1{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgdmlld0JveD0iMCAwIDEyODAgODYiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIHNsaWNlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmYiPjxwYXRoIGQ9Ik0xMjgwIDY2LjFjLTMuOCAwLTcuNi4zLTExLjQuOC0xOC4zLTMyLjYtNTkuNi00NC4yLTkyLjItMjUuOS0zLjUgMi02LjkgNC4zLTEwIDYuOS0yMi43LTQxLjctNzQuOS01Ny4yLTExNi42LTM0LjUtMTQuMiA3LjctMjUuOSAxOS4zLTMzLjggMzMuMy0uMi4zLS4zLjYtLjUuOC0xMi4yLTEuNC0yMy43IDUuOS0yNy43IDE3LjUtMTEuOS02LjEtMjUuOS02LjMtMzcuOS0uNi0yMS43LTMwLjQtNjQtMzcuNS05NC40LTE1LjctMTIuMSA4LjYtMjEgMjEtMjUuNCAzNS4yLTEwLjgtOS4zLTI0LjMtMTUtMzguNS0xNi4yLTguMS0yNC42LTM0LjYtMzgtNTkuMi0yOS45LTE0LjMgNC43LTI1LjUgMTYtMzAgMzAuMy00LjMtMS45LTguOS0zLjItMTMuNi0zLjgtMTMuNi00NS41LTYxLjUtNzEuNC0xMDctNTcuOGE4Ni4zOCA4Ni4zOCAwIDAgMC00My4yIDI5LjRjLTguNy0zLjYtMTguNy0xLjgtMjUuNCA0LjgtMjMuMS0yNC44LTYxLjktMjYuMi04Ni43LTMuMS03LjEgNi42LTEyLjUgMTQuOC0xNS45IDI0LTI2LjctMTAuMS01Ni45LS40LTcyLjggMjMuMy0yLjYtMi43LTUuNi01LjEtOC45LTYuOS0uNC0uMi0uOC0uNC0xLjItLjctLjYtMjUuOS0yMi00Ni40LTQ3LjktNDUuOC0xMS41LjMtMjIuNSA0LjctMzAuOSAxMi41LTE2LjUtMzMuNS01Ny4xLTQ3LjMtOTAuNi0zMC44LTIxLjkgMTEtMzYuMyAzMi43LTM3LjYgNTcuMS03LTIuMy0xNC41LTIuOC0yMS44LTEuNkM4NC44IDQ3IDU1LjcgNDAuNyAzNCA1NC44Yy01LjYgMy42LTEwLjMgOC40LTEzLjkgMTQtNi42LTEuNy0xMy4zLTIuNi0yMC4xLTIuNi0uMSAwIDAgMTkuOCAwIDE5LjhoMTI4MFY2Ni4xeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xNS42IDg2SDEyODBWNDguNWMtMy42IDEuMS03LjEgMi41LTEwLjQgNC40LTYuMyAzLjYtMTEuOCA4LjUtMTYgMTQuNS04LjEtMS41LTE2LjQtLjktMjQuMiAxLjctMy4yLTM5LTM3LjMtNjguMS03Ni40LTY0LjktMjQuOCAyLTQ2LjggMTYuOS01Ny45IDM5LjMtMTkuOS0xOC41LTUxLTE3LjMtNjkuNCAyLjYtOC4yIDguOC0xMi44IDIwLjMtMTMuMSAzMi4zLS40LjItLjkuNC0xLjMuNy0zLjUgMS45LTYuNiA0LjQtOS40IDcuMi0xNi42LTI0LjktNDguMi0zNS03Ni4yLTI0LjQtMTIuMi0zMy40LTQ5LjEtNTAuNi04Mi41LTM4LjQtOS41IDMuNS0xOC4xIDkuMS0yNSAxNi41LTcuMS02LjktMTcuNS04LjgtMjYuNi01LTMwLjQtMzkuMy04Ny00Ni4zLTEyNi4yLTE1LjgtMTQuOCAxMS41LTI1LjYgMjcuNC0zMSA0NS40LTQuOS42LTkuNyAxLjktMTQuMiAzLjktOC4yLTI1LjktMzUuOC00MC4yLTYxLjctMzItMTUgNC44LTI2LjkgMTYuNS0zMS44IDMxLjUtMTQuOSAxLjMtMjkgNy4yLTQwLjMgMTctMTEuNS0zNy40LTUxLjItNTguNC04OC43LTQ2LjgtMTQuOCA0LjYtMjcuNyAxMy45LTM2LjcgMjYuNS0xMi42LTYtMjcuMy01LjctMzkuNy42LTQuMS0xMi4yLTE2LjItMTkuOC0yOS0xOC40LS4yLS4zLS4zLS42LS41LS45LTI0LjQtNDMuMy03OS40LTU4LjYtMTIyLjctMzQuMi0xMy4zIDcuNS0yNC40IDE4LjItMzIuNCAzMS4yQzk5LjggMTguNSA1MCAyOC41IDI1LjQgNjUuNGMtNC4zIDYuNC03LjUgMTMuMy05LjggMjAuNnoiLz48L2c+PC9zdmc+);
            background-size: cover;
            background-position: center top;
            height: 200px;
            background-color: transparent;
        }
        .svg-light .svg1{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgdmlld0JveD0iMCAwIDEyODAgODYiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIHNsaWNlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDY2LjFjLTMuOCAwLTcuNi4zLTExLjQuOC0xOC4zLTMyLjYtNTkuNi00NC4yLTkyLjItMjUuOS0zLjUgMi02LjkgNC4zLTEwIDYuOS0yMi43LTQxLjctNzQuOS01Ny4yLTExNi42LTM0LjUtMTQuMiA3LjctMjUuOSAxOS4zLTMzLjggMzMuMy0uMi4zLS4zLjYtLjUuOC0xMi4yLTEuNC0yMy43IDUuOS0yNy43IDE3LjUtMTEuOS02LjEtMjUuOS02LjMtMzcuOS0uNi0yMS43LTMwLjQtNjQtMzcuNS05NC40LTE1LjctMTIuMSA4LjYtMjEgMjEtMjUuNCAzNS4yLTEwLjgtOS4zLTI0LjMtMTUtMzguNS0xNi4yLTguMS0yNC42LTM0LjYtMzgtNTkuMi0yOS45LTE0LjMgNC43LTI1LjUgMTYtMzAgMzAuMy00LjMtMS45LTguOS0zLjItMTMuNi0zLjgtMTMuNi00NS41LTYxLjUtNzEuNC0xMDctNTcuOGE4Ni4zOCA4Ni4zOCAwIDAgMC00My4yIDI5LjRjLTguNy0zLjYtMTguNy0xLjgtMjUuNCA0LjgtMjMuMS0yNC44LTYxLjktMjYuMi04Ni43LTMuMS03LjEgNi42LTEyLjUgMTQuOC0xNS45IDI0LTI2LjctMTAuMS01Ni45LS40LTcyLjggMjMuMy0yLjYtMi43LTUuNi01LjEtOC45LTYuOS0uNC0uMi0uOC0uNC0xLjItLjctLjYtMjUuOS0yMi00Ni40LTQ3LjktNDUuOC0xMS41LjMtMjIuNSA0LjctMzAuOSAxMi41LTE2LjUtMzMuNS01Ny4xLTQ3LjMtOTAuNi0zMC44LTIxLjkgMTEtMzYuMyAzMi43LTM3LjYgNTcuMS03LTIuMy0xNC41LTIuOC0yMS44LTEuNkM4NC44IDQ3IDU1LjcgNDAuNyAzNCA1NC44Yy01LjYgMy42LTEwLjMgOC40LTEzLjkgMTQtNi42LTEuNy0xMy4zLTIuNi0yMC4xLTIuNi0uMSAwIDAgMTkuOCAwIDE5LjhoMTI4MFY2Ni4xeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xNS42IDg2SDEyODBWNDguNWMtMy42IDEuMS03LjEgMi41LTEwLjQgNC40LTYuMyAzLjYtMTEuOCA4LjUtMTYgMTQuNS04LjEtMS41LTE2LjQtLjktMjQuMiAxLjctMy4yLTM5LTM3LjMtNjguMS03Ni40LTY0LjktMjQuOCAyLTQ2LjggMTYuOS01Ny45IDM5LjMtMTkuOS0xOC41LTUxLTE3LjMtNjkuNCAyLjYtOC4yIDguOC0xMi44IDIwLjMtMTMuMSAzMi4zLS40LjItLjkuNC0xLjMuNy0zLjUgMS45LTYuNiA0LjQtOS40IDcuMi0xNi42LTI0LjktNDguMi0zNS03Ni4yLTI0LjQtMTIuMi0zMy40LTQ5LjEtNTAuNi04Mi41LTM4LjQtOS41IDMuNS0xOC4xIDkuMS0yNSAxNi41LTcuMS02LjktMTcuNS04LjgtMjYuNi01LTMwLjQtMzkuMy04Ny00Ni4zLTEyNi4yLTE1LjgtMTQuOCAxMS41LTI1LjYgMjcuNC0zMSA0NS40LTQuOS42LTkuNyAxLjktMTQuMiAzLjktOC4yLTI1LjktMzUuOC00MC4yLTYxLjctMzItMTUgNC44LTI2LjkgMTYuNS0zMS44IDMxLjUtMTQuOSAxLjMtMjkgNy4yLTQwLjMgMTctMTEuNS0zNy40LTUxLjItNTguNC04OC43LTQ2LjgtMTQuOCA0LjYtMjcuNyAxMy45LTM2LjcgMjYuNS0xMi42LTYtMjcuMy01LjctMzkuNy42LTQuMS0xMi4yLTE2LjItMTkuOC0yOS0xOC40LS4yLS4zLS4zLS42LS41LS45LTI0LjQtNDMuMy03OS40LTU4LjYtMTIyLjctMzQuMi0xMy4zIDcuNS0yNC40IDE4LjItMzIuNCAzMS4yQzk5LjggMTguNSA1MCAyOC41IDI1LjQgNjUuNGMtNC4zIDYuNC03LjUgMTMuMy05LjggMjAuNnoiLz48L2c+PC9zdmc+);
        }
        .svg2{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNzRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBMNjQwIDcwIDAgMHYxNDBsNjQwLTcwIDY0MCA3MFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMjgwIDBIMGw2NDAgNzAgNjQwLTcweiIvPjwvZz48L3N2Zz4=);
            background-size: 166.66666666667% 274px;
            height: 136px;
            transform: rotateX(180deg);
        }
        .svg-light .svg2{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNzRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDBMNjQwIDcwIDAgMHYxNDBsNjQwLTcwIDY0MCA3MFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMjgwIDBIMGw2NDAgNzAgNjQwLTcweiIvPjwvZz48L3N2Zz4=);
        }
        .svg3{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyODJweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmYiPjxwYXRoIGQ9Ik0wIDQ3LjQ0TDE3MCAwbDYyNi40OCA5NC44OUwxMTEwIDg3LjExbDE3MC0zOS42N1YxNDBIMFY0Ny40NHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCA5MC43MmwxNDAtMjguMjggMzE1LjUyIDI0LjE0TDc5Ni40OCA2NS44IDExNDAgMTA0Ljg5bDE0MC0xNC4xN1YxNDBIMFY5MC43MnoiLz48L2c+PC9zdmc+);
            background-size: 100% 282px;
            height: 282px;
            transform: rotateY(180deg);
        }
        .svg-light .svg3{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyODJweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDQ3LjQ0TDE3MCAwbDYyNi40OCA5NC44OUwxMTEwIDg3LjExbDE3MC0zOS42N1YxNDBIMFY0Ny40NHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCA5MC43MmwxNDAtMjguMjggMzE1LjUyIDI0LjE0TDc5Ni40OCA2NS44IDExNDAgMTA0Ljg5bDE0MC0xNC4xN1YxNDBIMFY5MC43MnoiLz48L2c+PC9zdmc+);
        }


        .svg4 {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik04NTMuODkzLDg2Ljk5OGMtMzguODU5LDAtNTguODExLTE2LjQ1NS03Ny45NTYtMzUuMDUxYzE4LjI5NS0xMC41MzYsNDAuODkxLTE4LjI3Niw3My4zNzgtMTguMjc2IGMzOC42ODUsMCw2NC4xMzIsMTIuNTY0LDg1LjQ4OSwyOC4zNDdDOTE2LjE5Miw3Mi4wMTIsOTAwLjgsODYuOTk4LDg1My44OTMsODYuOTk4eiBNNTI2LjI2NSw4MC45NDUgYy02LjUxNy0wLjU2Mi0xMy41OTktMC44NzktMjEuNDEtMC44NzljLTcwLjc5OSwwLTkxLjMzNywyNy4yMjktMTM0LjQzMywzNS42NjJjMTQuOTAxLDMuNzIsMzIuMTE4LDYuMDcsNTIuODk4LDYuMDcgQzQ3MC4xNzEsMTIxLjc5Nyw1MDAuMzQsMTAzLjQyMSw1MjYuMjY1LDgwLjk0NXoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNNjYzLjQ1OCwxMDkuNjcxYy02Ny4xMzcsMC04MC4zNDUtMjMuODI0LTEzNy4xOTMtMjguNzI2QzU2Ny4wODYsNDUuNTU1LDU5Ny4zODEsMCw2NjUuNjkxLDAgYzYxLjg1NywwLDg1LjM2OSwyNy43ODIsMTEwLjI0Niw1MS45NDdDNzM2Ljg4OCw3NC40MzQsNzE3LjQ1OSwxMDkuNjcxLDY2My40NTgsMTA5LjY3MXogTTIxNy42OCw5NC4xNjMgYzU1Ljk3MSwwLDYyLjUyNiwyNC4wMjYsMTI2LjMzNywyNC4wMjZjOS44NTgsMCwxOC41MDgtMC45MTYsMjYuNDA0LTIuNDYxYy01Ny4xODYtMTQuMjc4LTgwLjE3Ny00OC44MDgtMTM4LjY1OS00OC44MDggYy03Ny4wNjMsMC05OS45Niw0OC41NjktMTUxLjc1MSw0OC41NjljLTQwLjAwNiwwLTYwLjAwOC0xMi4yMDYtODAuMDExLTI5LjUwNnYxNi44MDZjMjAuMDAzLDEwLjg5MSw0MC4wMDUsMjEuNzgyLDgwLjAxMSwyMS43ODIgQzE2MC4wMTQsMTI0LjU3LDE1OC42MDgsOTQuMTYzLDIxNy42OCw5NC4xNjN6IE0xMjAwLjExMiw0Ni4yOTJjLTU3LjQ5MywwLTU2LjkzNSw0Ni41OTUtMTE1LjAxNSw0Ni41OTUgYy01My42MTIsMC01OS43NTUtMzkuNjE4LTExNS42MDItMzkuNjE4Yy0xNS4yNjcsMC0yNS4zODEsMy43NTEtMzQuNjksOC43NDljMzYuMDk2LDI2LjY3NSw2MC41MDMsNjIuNTUyLDExNy4zNDIsNjIuNTUyIGM2OS4yNDksMCw3NS45NTEtNDMuNTU5LDE0Ny45NjQtNDMuNTU5YzM5LjgwNCwwLDU5Ljk4NiwxMC45NDMsNzkuODg4LDIxLjc3N1Y4NS45ODIgQzEyNjAuMDk3LDY4Ljc3MSwxMjM5LjkxNiw0Ni4yOTIsMTIwMC4xMTIsNDYuMjkyeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMDUyLjE0NywxMjQuNTdjLTU2Ljg0LDAtODEuMjQ3LTM1Ljg3Ni0xMTcuMzQyLTYyLjU1MmMtMTguNjEzLDkuOTk0LTM0LjAwNSwyNC45OC04MC45MTIsMjQuOTggYy0zOC44NTksMC01OC44MTEtMTYuNDU1LTc3Ljk1Ni0zNS4wNTFjLTM5LjA1LDIyLjQ4Ny01OC40NzksNTcuNzI0LTExMi40OCw1Ny43MjRjLTY3LjEzNywwLTgwLjM0NS0yMy44MjQtMTM3LjE5My0yOC43MjYgYy0yNS45MjUsMjIuNDc1LTU2LjA5Myw0MC44NTItMTAyLjk0Niw0MC44NTJjLTIwLjc3OSwwLTM3Ljk5Ni0yLjM0OS01Mi44OTgtNi4wN2MtNy44OTUsMS41NDUtMTYuNTQ2LDIuNDYxLTI2LjQwNCwyLjQ2MSBjLTYzLjgxMSwwLTcwLjM2Ni0yNC4wMjYtMTI2LjMzNy0yNC4wMjZjLTU5LjA3MiwwLTU3LjY2NSwzMC40MDctMTM3LjY2OSwzMC40MDdjLTQwLjAwNiwwLTYwLjAwOC0xMC44OTEtODAuMDExLTIxLjc4MlYxNDBoMTI4MCB2LTM3LjIxMmMtMTkuOTAzLTEwLjgzNS00MC4wODQtMjEuNzc3LTc5Ljg4OC0yMS43NzdDMTEyOC4wOTgsODEuMDExLDExMjEuMzk3LDEyNC41NywxMDUyLjE0NywxMjQuNTd6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 40% 200px;
            height: 200px;
        }
        .svg-light .svg4{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik04NTMuODkzLDg2Ljk5OGMtMzguODU5LDAtNTguODExLTE2LjQ1NS03Ny45NTYtMzUuMDUxYzE4LjI5NS0xMC41MzYsNDAuODkxLTE4LjI3Niw3My4zNzgtMTguMjc2IGMzOC42ODUsMCw2NC4xMzIsMTIuNTY0LDg1LjQ4OSwyOC4zNDdDOTE2LjE5Miw3Mi4wMTIsOTAwLjgsODYuOTk4LDg1My44OTMsODYuOTk4eiBNNTI2LjI2NSw4MC45NDUgYy02LjUxNy0wLjU2Mi0xMy41OTktMC44NzktMjEuNDEtMC44NzljLTcwLjc5OSwwLTkxLjMzNywyNy4yMjktMTM0LjQzMywzNS42NjJjMTQuOTAxLDMuNzIsMzIuMTE4LDYuMDcsNTIuODk4LDYuMDcgQzQ3MC4xNzEsMTIxLjc5Nyw1MDAuMzQsMTAzLjQyMSw1MjYuMjY1LDgwLjk0NXoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNNjYzLjQ1OCwxMDkuNjcxYy02Ny4xMzcsMC04MC4zNDUtMjMuODI0LTEzNy4xOTMtMjguNzI2QzU2Ny4wODYsNDUuNTU1LDU5Ny4zODEsMCw2NjUuNjkxLDAgYzYxLjg1NywwLDg1LjM2OSwyNy43ODIsMTEwLjI0Niw1MS45NDdDNzM2Ljg4OCw3NC40MzQsNzE3LjQ1OSwxMDkuNjcxLDY2My40NTgsMTA5LjY3MXogTTIxNy42OCw5NC4xNjMgYzU1Ljk3MSwwLDYyLjUyNiwyNC4wMjYsMTI2LjMzNywyNC4wMjZjOS44NTgsMCwxOC41MDgtMC45MTYsMjYuNDA0LTIuNDYxYy01Ny4xODYtMTQuMjc4LTgwLjE3Ny00OC44MDgtMTM4LjY1OS00OC44MDggYy03Ny4wNjMsMC05OS45Niw0OC41NjktMTUxLjc1MSw0OC41NjljLTQwLjAwNiwwLTYwLjAwOC0xMi4yMDYtODAuMDExLTI5LjUwNnYxNi44MDZjMjAuMDAzLDEwLjg5MSw0MC4wMDUsMjEuNzgyLDgwLjAxMSwyMS43ODIgQzE2MC4wMTQsMTI0LjU3LDE1OC42MDgsOTQuMTYzLDIxNy42OCw5NC4xNjN6IE0xMjAwLjExMiw0Ni4yOTJjLTU3LjQ5MywwLTU2LjkzNSw0Ni41OTUtMTE1LjAxNSw0Ni41OTUgYy01My42MTIsMC01OS43NTUtMzkuNjE4LTExNS42MDItMzkuNjE4Yy0xNS4yNjcsMC0yNS4zODEsMy43NTEtMzQuNjksOC43NDljMzYuMDk2LDI2LjY3NSw2MC41MDMsNjIuNTUyLDExNy4zNDIsNjIuNTUyIGM2OS4yNDksMCw3NS45NTEtNDMuNTU5LDE0Ny45NjQtNDMuNTU5YzM5LjgwNCwwLDU5Ljk4NiwxMC45NDMsNzkuODg4LDIxLjc3N1Y4NS45ODIgQzEyNjAuMDk3LDY4Ljc3MSwxMjM5LjkxNiw0Ni4yOTIsMTIwMC4xMTIsNDYuMjkyeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMDUyLjE0NywxMjQuNTdjLTU2Ljg0LDAtODEuMjQ3LTM1Ljg3Ni0xMTcuMzQyLTYyLjU1MmMtMTguNjEzLDkuOTk0LTM0LjAwNSwyNC45OC04MC45MTIsMjQuOTggYy0zOC44NTksMC01OC44MTEtMTYuNDU1LTc3Ljk1Ni0zNS4wNTFjLTM5LjA1LDIyLjQ4Ny01OC40NzksNTcuNzI0LTExMi40OCw1Ny43MjRjLTY3LjEzNywwLTgwLjM0NS0yMy44MjQtMTM3LjE5My0yOC43MjYgYy0yNS45MjUsMjIuNDc1LTU2LjA5Myw0MC44NTItMTAyLjk0Niw0MC44NTJjLTIwLjc3OSwwLTM3Ljk5Ni0yLjM0OS01Mi44OTgtNi4wN2MtNy44OTUsMS41NDUtMTYuNTQ2LDIuNDYxLTI2LjQwNCwyLjQ2MSBjLTYzLjgxMSwwLTcwLjM2Ni0yNC4wMjYtMTI2LjMzNy0yNC4wMjZjLTU5LjA3MiwwLTU3LjY2NSwzMC40MDctMTM3LjY2OSwzMC40MDdjLTQwLjAwNiwwLTYwLjAwOC0xMC44OTEtODAuMDExLTIxLjc4MlYxNDBoMTI4MCB2LTM3LjIxMmMtMTkuOTAzLTEwLjgzNS00MC4wODQtMjEuNzc3LTc5Ljg4OC0yMS43NzdDMTEyOC4wOTgsODEuMDExLDExMjEuMzk3LDEyNC41NywxMDUyLjE0NywxMjQuNTd6Ii8+PC9nPjwvc3ZnPg==);
        }
        .svg5{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MjVweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDMuNEMxMDUwLjU5IDE4IDEwMTkuNCA4NC44OSA3MzQuNDIgODQuODljLTMyMCAwLTMyMC04NC4zLTY0MC04NC4zQzU5LjQuNTkgMjguMiAxLjYgMCAzLjRWMTQwaDEyODB6IiBmaWxsLW9wYWNpdHk9Ii4zIi8+PHBhdGggZD0iTTAgMjQuMzFjNDMuNDYtNS42OSA5NC41Ni05LjI1IDE1OC40Mi05LjI1IDMyMCAwIDMyMCA4OS4yNCA2NDAgODkuMjQgMjU2LjEzIDAgMzA3LjI4LTU3LjE2IDQ4MS41OC04MFYxNDBIMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCA1MS43NmMtMjAxIDEyLjQ5LTI0Mi40MyA1My40LTUxMy41OCA1My40LTMyMCAwLTMyMC01Ny02NDAtNTctNDguODUuMDEtOTAuMjEgMS4zNS0xMjYuNDIgMy42VjE0MGgxMjgweiIvPjwvZz48L3N2Zz4=);
            background-size: 133.33333333333% 425px;
            bottom: 0;
            height: 425px;
            transform: rotateY(180deg);
        }
        .svg-light .svg5{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MjVweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDMuNEMxMDUwLjU5IDE4IDEwMTkuNCA4NC44OSA3MzQuNDIgODQuODljLTMyMCAwLTMyMC04NC4zLTY0MC04NC4zQzU5LjQuNTkgMjguMiAxLjYgMCAzLjRWMTQwaDEyODB6IiBmaWxsLW9wYWNpdHk9Ii4zIi8+PHBhdGggZD0iTTAgMjQuMzFjNDMuNDYtNS42OSA5NC41Ni05LjI1IDE1OC40Mi05LjI1IDMyMCAwIDMyMCA4OS4yNCA2NDAgODkuMjQgMjU2LjEzIDAgMzA3LjI4LTU3LjE2IDQ4MS41OC04MFYxNDBIMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCA1MS43NmMtMjAxIDEyLjQ5LTI0Mi40MyA1My40LTUxMy41OCA1My40LTMyMCAwLTMyMC01Ny02NDAtNTctNDguODUuMDEtOTAuMjEgMS4zNS0xMjYuNDIgMy42VjE0MGgxMjgweiIvPjwvZz48L3N2Zz4=);
        }

        .svg6{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 100% 200px;
            bottom: 0;
            height: 200px;
            transform: rotateY(180deg);
        }
        .svg-light .svg6{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
        }

        .svg7{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDB2NjBzNTczLjA5IDgwIDEyODAgODBWMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAwdjMwczU3My4wOSAxMTAgMTI4MCAxMTBWMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAwczU3My4wOSAxNDAgMTI4MCAxNDBWMHoiLz48L2c+PC9zdmc+);
            background-size: 100% 204px;
            height: 204px;
            transform: rotateX(180deg);
        }
        .svg-light .svg7{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDB2NjBzNTczLjA5IDgwIDEyODAgODBWMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAwdjMwczU3My4wOSAxMTAgMTI4MCAxMTBWMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAwczU3My4wOSAxNDAgMTI4MCAxNDBWMHoiLz48L2c+PC9zdmc+);
        }
        .svg8{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDdweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgMzAgMCAzMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgNjAgMCA2MHoiLz48L2c+PC9zdmc+);
            background-size: 100% 407px;
            height: 407px;
            transform: rotateY(180deg);
        }
        .svg-light .svg8{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDdweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgMzAgMCAzMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgNjAgMCA2MHoiLz48L2c+PC9zdmc+);
        }
        .svg9{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik04NTMuODkzLDg2Ljk5OGMtMzguODU5LDAtNTguODExLTE2LjQ1NS03Ny45NTYtMzUuMDUxYzE4LjI5NS0xMC41MzYsNDAuODkxLTE4LjI3Niw3My4zNzgtMTguMjc2IGMzOC42ODUsMCw2NC4xMzIsMTIuNTY0LDg1LjQ4OSwyOC4zNDdDOTE2LjE5Miw3Mi4wMTIsOTAwLjgsODYuOTk4LDg1My44OTMsODYuOTk4eiBNNTI2LjI2NSw4MC45NDUgYy02LjUxNy0wLjU2Mi0xMy41OTktMC44NzktMjEuNDEtMC44NzljLTcwLjc5OSwwLTkxLjMzNywyNy4yMjktMTM0LjQzMywzNS42NjJjMTQuOTAxLDMuNzIsMzIuMTE4LDYuMDcsNTIuODk4LDYuMDcgQzQ3MC4xNzEsMTIxLjc5Nyw1MDAuMzQsMTAzLjQyMSw1MjYuMjY1LDgwLjk0NXoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNNjYzLjQ1OCwxMDkuNjcxYy02Ny4xMzcsMC04MC4zNDUtMjMuODI0LTEzNy4xOTMtMjguNzI2QzU2Ny4wODYsNDUuNTU1LDU5Ny4zODEsMCw2NjUuNjkxLDAgYzYxLjg1NywwLDg1LjM2OSwyNy43ODIsMTEwLjI0Niw1MS45NDdDNzM2Ljg4OCw3NC40MzQsNzE3LjQ1OSwxMDkuNjcxLDY2My40NTgsMTA5LjY3MXogTTIxNy42OCw5NC4xNjMgYzU1Ljk3MSwwLDYyLjUyNiwyNC4wMjYsMTI2LjMzNywyNC4wMjZjOS44NTgsMCwxOC41MDgtMC45MTYsMjYuNDA0LTIuNDYxYy01Ny4xODYtMTQuMjc4LTgwLjE3Ny00OC44MDgtMTM4LjY1OS00OC44MDggYy03Ny4wNjMsMC05OS45Niw0OC41NjktMTUxLjc1MSw0OC41NjljLTQwLjAwNiwwLTYwLjAwOC0xMi4yMDYtODAuMDExLTI5LjUwNnYxNi44MDZjMjAuMDAzLDEwLjg5MSw0MC4wMDUsMjEuNzgyLDgwLjAxMSwyMS43ODIgQzE2MC4wMTQsMTI0LjU3LDE1OC42MDgsOTQuMTYzLDIxNy42OCw5NC4xNjN6IE0xMjAwLjExMiw0Ni4yOTJjLTU3LjQ5MywwLTU2LjkzNSw0Ni41OTUtMTE1LjAxNSw0Ni41OTUgYy01My42MTIsMC01OS43NTUtMzkuNjE4LTExNS42MDItMzkuNjE4Yy0xNS4yNjcsMC0yNS4zODEsMy43NTEtMzQuNjksOC43NDljMzYuMDk2LDI2LjY3NSw2MC41MDMsNjIuNTUyLDExNy4zNDIsNjIuNTUyIGM2OS4yNDksMCw3NS45NTEtNDMuNTU5LDE0Ny45NjQtNDMuNTU5YzM5LjgwNCwwLDU5Ljk4NiwxMC45NDMsNzkuODg4LDIxLjc3N1Y4NS45ODIgQzEyNjAuMDk3LDY4Ljc3MSwxMjM5LjkxNiw0Ni4yOTIsMTIwMC4xMTIsNDYuMjkyeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMDUyLjE0NywxMjQuNTdjLTU2Ljg0LDAtODEuMjQ3LTM1Ljg3Ni0xMTcuMzQyLTYyLjU1MmMtMTguNjEzLDkuOTk0LTM0LjAwNSwyNC45OC04MC45MTIsMjQuOTggYy0zOC44NTksMC01OC44MTEtMTYuNDU1LTc3Ljk1Ni0zNS4wNTFjLTM5LjA1LDIyLjQ4Ny01OC40NzksNTcuNzI0LTExMi40OCw1Ny43MjRjLTY3LjEzNywwLTgwLjM0NS0yMy44MjQtMTM3LjE5My0yOC43MjYgYy0yNS45MjUsMjIuNDc1LTU2LjA5Myw0MC44NTItMTAyLjk0Niw0MC44NTJjLTIwLjc3OSwwLTM3Ljk5Ni0yLjM0OS01Mi44OTgtNi4wN2MtNy44OTUsMS41NDUtMTYuNTQ2LDIuNDYxLTI2LjQwNCwyLjQ2MSBjLTYzLjgxMSwwLTcwLjM2Ni0yNC4wMjYtMTI2LjMzNy0yNC4wMjZjLTU5LjA3MiwwLTU3LjY2NSwzMC40MDctMTM3LjY2OSwzMC40MDdjLTQwLjAwNiwwLTYwLjAwOC0xMC44OTEtODAuMDExLTIxLjc4MlYxNDBoMTI4MCB2LTM3LjIxMmMtMTkuOTAzLTEwLjgzNS00MC4wODQtMjEuNzc3LTc5Ljg4OC0yMS43NzdDMTEyOC4wOTgsODEuMDExLDExMjEuMzk3LDEyNC41NywxMDUyLjE0NywxMjQuNTd6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 100% 300px;
            height: 300px;
        }
        .svg-light .svg9{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik04NTMuODkzLDg2Ljk5OGMtMzguODU5LDAtNTguODExLTE2LjQ1NS03Ny45NTYtMzUuMDUxYzE4LjI5NS0xMC41MzYsNDAuODkxLTE4LjI3Niw3My4zNzgtMTguMjc2IGMzOC42ODUsMCw2NC4xMzIsMTIuNTY0LDg1LjQ4OSwyOC4zNDdDOTE2LjE5Miw3Mi4wMTIsOTAwLjgsODYuOTk4LDg1My44OTMsODYuOTk4eiBNNTI2LjI2NSw4MC45NDUgYy02LjUxNy0wLjU2Mi0xMy41OTktMC44NzktMjEuNDEtMC44NzljLTcwLjc5OSwwLTkxLjMzNywyNy4yMjktMTM0LjQzMywzNS42NjJjMTQuOTAxLDMuNzIsMzIuMTE4LDYuMDcsNTIuODk4LDYuMDcgQzQ3MC4xNzEsMTIxLjc5Nyw1MDAuMzQsMTAzLjQyMSw1MjYuMjY1LDgwLjk0NXoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNNjYzLjQ1OCwxMDkuNjcxYy02Ny4xMzcsMC04MC4zNDUtMjMuODI0LTEzNy4xOTMtMjguNzI2QzU2Ny4wODYsNDUuNTU1LDU5Ny4zODEsMCw2NjUuNjkxLDAgYzYxLjg1NywwLDg1LjM2OSwyNy43ODIsMTEwLjI0Niw1MS45NDdDNzM2Ljg4OCw3NC40MzQsNzE3LjQ1OSwxMDkuNjcxLDY2My40NTgsMTA5LjY3MXogTTIxNy42OCw5NC4xNjMgYzU1Ljk3MSwwLDYyLjUyNiwyNC4wMjYsMTI2LjMzNywyNC4wMjZjOS44NTgsMCwxOC41MDgtMC45MTYsMjYuNDA0LTIuNDYxYy01Ny4xODYtMTQuMjc4LTgwLjE3Ny00OC44MDgtMTM4LjY1OS00OC44MDggYy03Ny4wNjMsMC05OS45Niw0OC41NjktMTUxLjc1MSw0OC41NjljLTQwLjAwNiwwLTYwLjAwOC0xMi4yMDYtODAuMDExLTI5LjUwNnYxNi44MDZjMjAuMDAzLDEwLjg5MSw0MC4wMDUsMjEuNzgyLDgwLjAxMSwyMS43ODIgQzE2MC4wMTQsMTI0LjU3LDE1OC42MDgsOTQuMTYzLDIxNy42OCw5NC4xNjN6IE0xMjAwLjExMiw0Ni4yOTJjLTU3LjQ5MywwLTU2LjkzNSw0Ni41OTUtMTE1LjAxNSw0Ni41OTUgYy01My42MTIsMC01OS43NTUtMzkuNjE4LTExNS42MDItMzkuNjE4Yy0xNS4yNjcsMC0yNS4zODEsMy43NTEtMzQuNjksOC43NDljMzYuMDk2LDI2LjY3NSw2MC41MDMsNjIuNTUyLDExNy4zNDIsNjIuNTUyIGM2OS4yNDksMCw3NS45NTEtNDMuNTU5LDE0Ny45NjQtNDMuNTU5YzM5LjgwNCwwLDU5Ljk4NiwxMC45NDMsNzkuODg4LDIxLjc3N1Y4NS45ODIgQzEyNjAuMDk3LDY4Ljc3MSwxMjM5LjkxNiw0Ni4yOTIsMTIwMC4xMTIsNDYuMjkyeiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMDUyLjE0NywxMjQuNTdjLTU2Ljg0LDAtODEuMjQ3LTM1Ljg3Ni0xMTcuMzQyLTYyLjU1MmMtMTguNjEzLDkuOTk0LTM0LjAwNSwyNC45OC04MC45MTIsMjQuOTggYy0zOC44NTksMC01OC44MTEtMTYuNDU1LTc3Ljk1Ni0zNS4wNTFjLTM5LjA1LDIyLjQ4Ny01OC40NzksNTcuNzI0LTExMi40OCw1Ny43MjRjLTY3LjEzNywwLTgwLjM0NS0yMy44MjQtMTM3LjE5My0yOC43MjYgYy0yNS45MjUsMjIuNDc1LTU2LjA5Myw0MC44NTItMTAyLjk0Niw0MC44NTJjLTIwLjc3OSwwLTM3Ljk5Ni0yLjM0OS01Mi44OTgtNi4wN2MtNy44OTUsMS41NDUtMTYuNTQ2LDIuNDYxLTI2LjQwNCwyLjQ2MSBjLTYzLjgxMSwwLTcwLjM2Ni0yNC4wMjYtMTI2LjMzNy0yNC4wMjZjLTU5LjA3MiwwLTU3LjY2NSwzMC40MDctMTM3LjY2OSwzMC40MDdjLTQwLjAwNiwwLTYwLjAwOC0xMC44OTEtODAuMDExLTIxLjc4MlYxNDBoMTI4MCB2LTM3LjIxMmMtMTkuOTAzLTEwLjgzNS00MC4wODQtMjEuNzc3LTc5Ljg4OC0yMS43NzdDMTEyOC4wOTgsODEuMDExLDExMjEuMzk3LDEyNC41NywxMDUyLjE0NywxMjQuNTd6Ii8+PC9nPjwvc3ZnPg==);
        }
        .svg10{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDE0MFYwSDBsMTI4MCAxNDB6IiBmaWxsLW9wYWNpdHk9Ii41Ii8+PHBhdGggZD0iTTEyODAgOThWMEgwbDEyODAgOTh6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 100% 300px;
            transform: rotateX(180deg);
            height: 300px;
        }
        .svg-light .svg10{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDE0MFYwSDBsMTI4MCAxNDB6IiBmaWxsLW9wYWNpdHk9Ii41Ii8+PHBhdGggZD0iTTEyODAgOThWMEgwbDEyODAgOTh6Ii8+PC9nPjwvc3ZnPg==);
        }
        .svg11{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI1MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDB2MTQwaDEyODBMMCAweiIvPjwvZz48L3N2Zz4=);
            background-size: 200% 200px;
            height: 200px;
        }
        .svg-light .svg11{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI1MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDB2MTQwaDEyODBMMCAweiIvPjwvZz48L3N2Zz4=);
        }
        .svg12{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 100% 400px;
            height: 400px;
            z-index: 1;
        }
        .svg-light .svg12{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
        }
        .svg13{
            transform: rotateY(180deg);
            background-image: url( data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNTBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiLz48L2c+PC9zdmc+);
            background-size: 100% 250px;
            height: 250px;
        }
        .svg-light .svg13{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNTBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiLz48L2c+PC9zdmc+);
        }
        .svg14{
            background-image: url( data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0ODBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgMzAgMCAzMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgNjAgMCA2MHoiLz48L2c+PC9zdmc+);
            background-size: 100% 480px;
            height: 480px;
            transform: rotateY(180deg);
        }
        .svg-light .svg14{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0ODBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDE0MGgxMjgwQzU3My4wOCAxNDAgMCAwIDAgMHoiIGZpbGwtb3BhY2l0eT0iLjMiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgMzAgMCAzMHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCAxNDBoMTI4MEM1NzMuMDggMTQwIDAgNjAgMCA2MHoiLz48L2c+PC9zdmc+);
        }
        .svg15{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0wIDBsNjQuOCAzMC45NSA5MS4yLTIuNTQgOTUuNDYgMjcuODcgMTIwLjA0LjJMNDQzIDgzLjE1bDkwLjA5LTMuMTJMNjQwIDExMC4xMmwxMDIuMzktMjkuNzMgODUuNTUgOC41MSA4OC4xMS01Ljc1TDk5MiA1Mi4yMmw3My4yMSA0LjI2TDExMzIgMzguNzlsNzctLjMzTDEyODAgMHYxNDBIMFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0wIDBsNjQuOCAzOC42OSA5MS4yLTMuMTggOTUuNDYgMzQuODQgMTIwLjA0LjI0IDcxLjUgMzMuMzUgOTAuMDktMy45MUw2NDAgMTM3LjY1bDEwMi4zOS0zNy4xNyA4NS41NSAxMC42NSA4OC4xMS03LjE5TDk5MiA2NS4yOGw3My4yMSA1LjMxIDY2Ljc5LTIyLjEgNzctLjQxTDEyODAgMHYxNDBIMFYweiIvPjwvZz48L3N2Zz4=);
            background-size: 100% 300px;
            height: 300px;
        }
        .svg-light .svg15{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDBsNjQuOCAzMC45NSA5MS4yLTIuNTQgOTUuNDYgMjcuODcgMTIwLjA0LjJMNDQzIDgzLjE1bDkwLjA5LTMuMTJMNjQwIDExMC4xMmwxMDIuMzktMjkuNzMgODUuNTUgOC41MSA4OC4xMS01Ljc1TDk5MiA1Mi4yMmw3My4yMSA0LjI2TDExMzIgMzguNzlsNzctLjMzTDEyODAgMHYxNDBIMFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0wIDBsNjQuOCAzOC42OSA5MS4yLTMuMTggOTUuNDYgMzQuODQgMTIwLjA0LjI0IDcxLjUgMzMuMzUgOTAuMDktMy45MUw2NDAgMTM3LjY1bDEwMi4zOS0zNy4xNyA4NS41NSAxMC42NSA4OC4xMS03LjE5TDk5MiA2NS4yOGw3My4yMSA1LjMxIDY2Ljc5LTIyLjEgNzctLjQxTDEyODAgMHYxNDBIMFYweiIvPjwvZz48L3N2Zz4=);
        }
        .svg16{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDk2MiAxMTUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDk2MiAxMTU7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiBjbGFzcz0ic3ZnIHJlcGxhY2VkLXN2ZyI+CiAgICAgICAgICAgICAgICAgICAgPHBhdGggIGZpbGw9IiNmZmYiIGQ9Ik0wLDBjMCwwLDEwMCw5NCw0ODEsOTVDODYyLDk0LDk2MiwwLDk2MiwwdjExNUgwVjB6Ij48L3BhdGg+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
            background-size: 100%;
            height: 300px;
        }
        .svg-light .svg16{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDk2MiAxMTUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDk2MiAxMTU7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiBjbGFzcz0ic3ZnIHJlcGxhY2VkLXN2ZyI+CiAgICAgICAgICAgICAgICAgICAgPHBhdGggIGZpbGw9IiNmNGY0ZjQiIGQ9Ik0wLDBjMCwwLDEwMCw5NCw0ODEsOTVDODYyLDk0LDk2MiwwLDk2MiwwdjExNUgwVjB6Ij48L3BhdGg+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
        }
        .svg17 {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNzRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBMNjQwIDcwIDAgMHYxNDBsNjQwLTcwIDY0MCA3MFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMjgwIDBIMGw2NDAgNzAgNjQwLTcweiIvPjwvZz48L3N2Zz4=);
            background-size: 10.666667% 147px;
            height: 147px;
            transform: rotateX(180deg);
        }
        .svg-light .svg17{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyNzRweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDBMNjQwIDcwIDAgMHYxNDBsNjQwLTcwIDY0MCA3MFYweiIgZmlsbC1vcGFjaXR5PSIuNSIvPjxwYXRoIGQ9Ik0xMjgwIDBIMGw2NDAgNzAgNjQwLTcweiIvPjwvZz48L3N2Zz4=);
        }
        .svg18{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmZmZmYiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 100% 400px;
            height: 400px;
            z-index: 1;
            transform: rotateY(180deg);
        }
        .svg-light .svg18{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI0MDBweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0xMjgwIDBsLTI2NiA5MS41MmE3Mi41OSA3Mi41OSAwIDAgMS0zMC43NiAzLjcxTDAgMHYxNDBoMTI4MHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMTI4MCAwbC0yNjIuMSAxMTYuMjZhNzMuMjkgNzMuMjkgMCAwIDEtMzkuMDkgNkwwIDB2MTQwaDEyODB6Ii8+PC9nPjwvc3ZnPg==);
        }
        .svg19 {
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyODJweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmZmYiPjxwYXRoIGQ9Ik0wIDQ3LjQ0TDE3MCAwbDYyNi40OCA5NC44OUwxMTEwIDg3LjExbDE3MC0zOS42N1YxNDBIMFY0Ny40NHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCA5MC43MmwxNDAtMjguMjggMzE1LjUyIDI0LjE0TDc5Ni40OCA2NS44IDExNDAgMTA0Ljg5bDE0MC0xNC4xN1YxNDBIMFY5MC43MnoiLz48L2c+PC9zdmc+);
            background-size: 126% 322px;
            height: 249px;
            transform: rotateY(180deg);
        }
        .svg-light .svg19{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyODJweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik0wIDQ3LjQ0TDE3MCAwbDYyNi40OCA5NC44OUwxMTEwIDg3LjExbDE3MC0zOS42N1YxNDBIMFY0Ny40NHoiIGZpbGwtb3BhY2l0eT0iLjUiLz48cGF0aCBkPSJNMCA5MC43MmwxNDAtMjguMjggMzE1LjUyIDI0LjE0TDc5Ni40OCA2NS44IDExNDAgMTA0Ljg5bDE0MC0xNC4xN1YxNDBIMFY5MC43MnoiLz48L2c+PC9zdmc+);
        }
        .svg20{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMTkyMCAzMTAiIHZlcnNpb249IjEuMSIgY2xhc3M9InN2ZyByZXBsYWNlZC1zdmciPgogICAgICAgICAgICAgICAgICAgIDxnIGlkPSJMYW5kaW5nLVBhZ2VzIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0iI2ZmZiIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9IjAzX3ZBcHAtdjMtQ29weSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsIC01NTQuMDAwMDAwKSIgZmlsbD0iI0ZGRkZGRiI+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNLTMsNTUxIEMxODYuMjU3NTg5LDc1Ny4zMjExMTggMzE5LjA0NDQxNCw4NTYuMzIyNDU0IDM5NS4zNjA0NzUsODQ4LjAwNDAwNyBDNTA5LjgzNDU2Niw4MzUuNTI2MzM3IDU2MS41MjUxNDMsNzk2LjMyOTIxMiA2MzcuNzMxNzM0LDc2NS45NjE1NDkgQzcxMy45MzgzMjUsNzM1LjU5Mzg4NiA4MTYuOTgwNjQ2LDY4MS45MTA1NzcgMTAzNS43MjIwOCw3MzMuMDY1NDY5IEMxMjU0LjQ2MzUxLDc4NC4yMjAzNjEgMTUxMS41NDkyNSw2NzguOTIzNTkgMTUzOS40MDgwOCw2NjIuMzk4NjY1IEMxNTY3LjI2NjksNjQ1Ljg3Mzc0IDE2NjAuOTE0Myw1OTEuNDc4NTc0IDE3NzMuMTkzNzgsNTk3LjY0MTg2OCBDMTg0OC4wNDY3Nyw2MDEuNzUwNzMgMTkwMS43NTY0NSw1ODguMzU3Njc1IDE5MzQuMzIyODQsNTU3LjQ2MjcwNCBMMTkzNC4zMjI4NCw4NjMuMTgzMzk1IEwtMyw4NjMuMTgzMzk1IiBpZD0iUGF0aC03Ij48L3BhdGg+CiAgICAgICAgICAgICAgICAgICAgICAgIDwvZz4KICAgICAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
            background-size: cover;
            height: 304px;
            background-position: center;
            bottom: -1px;
        }
        .svg-light .svg20{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2aWV3Qm94PSIwIDAgMTkyMCAzMTAiIHZlcnNpb249IjEuMSIgY2xhc3M9InN2ZyByZXBsYWNlZC1zdmciPgogICAgICAgICAgICAgICAgICAgIDxnIGlkPSJMYW5kaW5nLVBhZ2VzIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0iI2Y0ZjRmNCIgZmlsbC1ydWxlPSJldmVub2RkIj4KICAgICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9IjAzX3ZBcHAtdjMtQ29weSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsIC01NTQuMDAwMDAwKSIgZmlsbD0iI2Y0ZjRmNCI+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNLTMsNTUxIEMxODYuMjU3NTg5LDc1Ny4zMjExMTggMzE5LjA0NDQxNCw4NTYuMzIyNDU0IDM5NS4zNjA0NzUsODQ4LjAwNDAwNyBDNTA5LjgzNDU2Niw4MzUuNTI2MzM3IDU2MS41MjUxNDMsNzk2LjMyOTIxMiA2MzcuNzMxNzM0LDc2NS45NjE1NDkgQzcxMy45MzgzMjUsNzM1LjU5Mzg4NiA4MTYuOTgwNjQ2LDY4MS45MTA1NzcgMTAzNS43MjIwOCw3MzMuMDY1NDY5IEMxMjU0LjQ2MzUxLDc4NC4yMjAzNjEgMTUxMS41NDkyNSw2NzguOTIzNTkgMTUzOS40MDgwOCw2NjIuMzk4NjY1IEMxNTY3LjI2NjksNjQ1Ljg3Mzc0IDE2NjAuOTE0Myw1OTEuNDc4NTc0IDE3NzMuMTkzNzgsNTk3LjY0MTg2OCBDMTg0OC4wNDY3Nyw2MDEuNzUwNzMgMTkwMS43NTY0NSw1ODguMzU3Njc1IDE5MzQuMzIyODQsNTU3LjQ2MjcwNCBMMTkzNC4zMjI4NCw4NjMuMTgzMzk1IEwtMyw4NjMuMTgzMzk1IiBpZD0iUGF0aC03Ij48L3BhdGg+CiAgICAgICAgICAgICAgICAgICAgICAgIDwvZz4KICAgICAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
        }
        .svg21{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE5MjAgMzk3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOTIwIDM5NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIGNsYXNzPSJzdmcgcmVwbGFjZWQtc3ZnIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBmaWxsPSIjZmZmIiBkPSJNMTkyMCwwdjM5N0gwVjY0LjRjMTA5LjgsMjI2LjksMzY4LjUsMzUxLjMsNjIxLDI4My43TDE5MjAsMHoiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDwvc3ZnPg==);
            background-size: cover;
            height: 370px;
        }
        .svg-light .svg21{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDE5MjAgMzk3IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOTIwIDM5NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIGNsYXNzPSJzdmcgcmVwbGFjZWQtc3ZnIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBmaWxsPSIjZjRmNGY0IiBkPSJNMTkyMCwwdjM5N0gwVjY0LjRjMTA5LjgsMjI2LjksMzY4LjUsMzUxLjMsNjIxLDI4My43TDE5MjAsMHoiPjwvcGF0aD4KICAgICAgICAgICAgICAgIDwvc3ZnPg==);
        }
        .svg22{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDBweCIgdmlld0JveD0iMCAwIDEyODAgODYiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIHNsaWNlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xMykiPjxwYXRoIGQ9Ik04MzMuOSAyNy41Yy01LjggMy4yLTExIDcuMy0xNS41IDEyLjItNy4xLTYuOS0xNy41LTguOC0yNi42LTUtMzAuNi0zOS4yLTg3LjMtNDYuMS0xMjYuNS0xNS41LTEuNCAxLjEtMi44IDIuMi00LjEgMy40QzY3NC40IDMzLjQgNjg0IDQ4IDY4OC44IDY0LjNjNC43LjYgOS4zIDEuOCAxMy42IDMuOCA3LjgtMjQuNyAzNC4yLTM4LjMgNTguOS0zMC41IDE0LjQgNC42IDI1LjYgMTUuNyAzMC4zIDMwIDE0LjIgMS4yIDI3LjcgNi45IDM4LjUgMTYuMkM4NDAuNiA0OS42IDg3NiAyOS41IDkxMC44IDM4Yy0yMC40LTIwLjMtNTEuOC0yNC42LTc2LjktMTAuNXpNMzg0IDQzLjljLTkgNS0xNi43IDExLjktMjIuNyAyMC4zIDE1LjQtNy44IDMzLjMtOC43IDQ5LjQtMi42IDMuNy0xMC4xIDkuOS0xOS4xIDE4LjEtMjYtMTUuNC0yLjMtMzEuMi42LTQ0LjggOC4zem01NjAuMiAxMy42YzIgMi4yIDMuOSA0LjUgNS43IDYuOSA1LjYtMi42IDExLjYtNCAxNy44LTQuMS03LjYtMi40LTE1LjYtMy4zLTIzLjUtMi44ek0xNzguNyA3YzI5LTQuMiA1Ny4zIDEwLjggNzAuMyAzNyA4LjktOC4zIDIwLjctMTIuOCAzMi45LTEyLjVDMjU2LjQgMS44IDIxNC43LTguMSAxNzguNyA3em0xNDYuNSA1Ni4zYzEuNSA0LjUgMi40IDkuMiAyLjUgMTQgLjQuMi44LjQgMS4yLjcgMy4zIDEuOSA2LjMgNC4yIDguOSA2LjkgNS44LTguNyAxMy43LTE1LjcgMjIuOS0yMC41LTExLjEtNS4yLTIzLjktNS42LTM1LjUtMS4xek0zMy41IDU0LjljMjEuNi0xNC40IDUwLjctOC41IDY1IDEzIC4xLjIuMi4zLjMuNSA3LjMtMS4yIDE0LjgtLjYgMjEuOCAxLjYuNi0xMC4zIDMuNS0yMC40IDguNi0yOS40LjMtLjYuNy0xLjIgMS4xLTEuOC0zMi4xLTE3LjItNzEuOS0xMC42LTk2LjggMTYuMXptMTIyOC45IDIuN2MyLjMgMi45IDQuNCA1LjkgNi4yIDkuMSAzLjgtLjUgNy42LS44IDExLjQtLjhWNDguM2MtNi40IDEuOC0xMi40IDUtMTcuNiA5LjN6TTExMjcuMyAxMWMxLjkuOSAzLjcgMS44IDUuNiAyLjggMTQuMiA3LjkgMjUuOCAxOS43IDMzLjUgMzQgMTMuOS0xMS40IDMxLjctMTYuOSA0OS42LTE1LjMtMjAuNS0yNy43LTU3LjgtMzYuOC04OC43LTIxLjV6IiBmaWxsLW9wYWNpdHk9Ii41Ii8+PHBhdGggZD0iTTAgMHY2NmM2LjggMCAxMy41LjkgMjAuMSAyLjYgMy41LTUuNCA4LjEtMTAuMSAxMy40LTEzLjYgMjQuOS0yNi44IDY0LjctMzMuNCA5Ni44LTE2IDEwLjUtMTcuNCAyOC4yLTI5LjEgNDguMy0zMiAzNi4xLTE1LjEgNzcuNy01LjIgMTAzLjIgMjQuNSAxOS43LjQgMzcuMSAxMy4xIDQzLjQgMzEuOCAxMS41LTQuNSAyNC40LTQuMiAzNS42IDEuMWwuNC0uMmMxNS40LTIxLjQgNDEuNS0zMi40IDY3LjYtMjguNiAyNS0yMSA2Mi4xLTE4LjggODQuNCA1LjEgNi43LTYuNiAxNi43LTguNCAyNS40LTQuOCAyOS4yLTM3LjQgODMuMy00NC4xIDEyMC43LTE0LjhsMS44IDEuNWMzNy4zLTMyLjkgOTQuMy0yOS4zIDEyNy4yIDggMS4yIDEuMyAyLjMgMi43IDMuNCA0LjEgOS4xLTMuOCAxOS41LTEuOSAyNi42IDUgMjQuMy0yNiA2NS0yNy4zIDkxLTMuMS41LjUgMSAuOSAxLjUgMS40IDEyLjggMy4xIDI0LjQgOS45IDMzLjQgMTkuNSA3LjktLjUgMTUuOS40IDIzLjUgMi44IDctLjEgMTMuOSAxLjUgMjAuMSA0LjcgMy45LTExLjYgMTUuNS0xOC45IDI3LjctMTcuNS4yLS4zLjMtLjYuNS0uOSAyMi4xLTM5LjIgNzAuNy01NC43IDExMS40LTM1LjYgMzAuOC0xNS4zIDY4LjItNi4yIDg4LjYgMjEuNSAxOC4zIDEuNyAzNSAxMC44IDQ2LjUgMjUuMSA1LjItNC4zIDExLjEtNy40IDE3LjYtOS4zVjBIMHoiLz48L2c+PC9zdmc+);
            background-size: cover;
            background-position: center top;
            top: 0;
            height: 200px;
            z-index: 1;
            background-color: transparent;
        }
        .svg-light .svg22{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIyMDBweCIgdmlld0JveD0iMCAwIDEyODAgODYiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIHNsaWNlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9IiNmNGY0ZjQiPjxwYXRoIGQ9Ik04MzMuOSAyNy41Yy01LjggMy4yLTExIDcuMy0xNS41IDEyLjItNy4xLTYuOS0xNy41LTguOC0yNi42LTUtMzAuNi0zOS4yLTg3LjMtNDYuMS0xMjYuNS0xNS41LTEuNCAxLjEtMi44IDIuMi00LjEgMy40QzY3NC40IDMzLjQgNjg0IDQ4IDY4OC44IDY0LjNjNC43LjYgOS4zIDEuOCAxMy42IDMuOCA3LjgtMjQuNyAzNC4yLTM4LjMgNTguOS0zMC41IDE0LjQgNC42IDI1LjYgMTUuNyAzMC4zIDMwIDE0LjIgMS4yIDI3LjcgNi45IDM4LjUgMTYuMkM4NDAuNiA0OS42IDg3NiAyOS41IDkxMC44IDM4Yy0yMC40LTIwLjMtNTEuOC0yNC42LTc2LjktMTAuNXpNMzg0IDQzLjljLTkgNS0xNi43IDExLjktMjIuNyAyMC4zIDE1LjQtNy44IDMzLjMtOC43IDQ5LjQtMi42IDMuNy0xMC4xIDkuOS0xOS4xIDE4LjEtMjYtMTUuNC0yLjMtMzEuMi42LTQ0LjggOC4zem01NjAuMiAxMy42YzIgMi4yIDMuOSA0LjUgNS43IDYuOSA1LjYtMi42IDExLjYtNCAxNy44LTQuMS03LjYtMi40LTE1LjYtMy4zLTIzLjUtMi44ek0xNzguNyA3YzI5LTQuMiA1Ny4zIDEwLjggNzAuMyAzNyA4LjktOC4zIDIwLjctMTIuOCAzMi45LTEyLjVDMjU2LjQgMS44IDIxNC43LTguMSAxNzguNyA3em0xNDYuNSA1Ni4zYzEuNSA0LjUgMi40IDkuMiAyLjUgMTQgLjQuMi44LjQgMS4yLjcgMy4zIDEuOSA2LjMgNC4yIDguOSA2LjkgNS44LTguNyAxMy43LTE1LjcgMjIuOS0yMC41LTExLjEtNS4yLTIzLjktNS42LTM1LjUtMS4xek0zMy41IDU0LjljMjEuNi0xNC40IDUwLjctOC41IDY1IDEzIC4xLjIuMi4zLjMuNSA3LjMtMS4yIDE0LjgtLjYgMjEuOCAxLjYuNi0xMC4zIDMuNS0yMC40IDguNi0yOS40LjMtLjYuNy0xLjIgMS4xLTEuOC0zMi4xLTE3LjItNzEuOS0xMC42LTk2LjggMTYuMXptMTIyOC45IDIuN2MyLjMgMi45IDQuNCA1LjkgNi4yIDkuMSAzLjgtLjUgNy42LS44IDExLjQtLjhWNDguM2MtNi40IDEuOC0xMi40IDUtMTcuNiA5LjN6TTExMjcuMyAxMWMxLjkuOSAzLjcgMS44IDUuNiAyLjggMTQuMiA3LjkgMjUuOCAxOS43IDMzLjUgMzQgMTMuOS0xMS40IDMxLjctMTYuOSA0OS42LTE1LjMtMjAuNS0yNy43LTU3LjgtMzYuOC04OC43LTIxLjV6IiBmaWxsLW9wYWNpdHk9Ii41Ii8);
        }
        .svg23{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIyMDAgNzQ0LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDIyMDAgNzQ0LjQ7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0ic3ZnIHJlcGxhY2VkLXN2ZyI+CiAgICAgICAgICAgICAgICAgICAgPGc+CiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0yMjAwLDUxMXYyMzMuNUgwVjBsMjQ4LjgsMTY0bDQ3Ni44LDQ1OC40bDE5MS40LTE4bDExMC45LDczLjFsNzEyLjQtMTM1LjEgICBDMTg2NS40LDUzNC4yLDIwOTIuOSw1MTguNCwyMjAwLDUxMXoiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICAgICAgPHBvbHlnb24gZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjQ3KSIgcG9pbnRzPSI5MTcsNjA0LjUgNzIxLjgsNjMzLjggMjQ4LjgsMTY0ICAiPjwvcG9seWdvbj4KICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjQ3KSIgZD0iTTIyMDAsNDU1LjN2ODIuNWMtMTE3LjEsMi43LTMzNC42LTMuNi00NTkuNyw0LjdMMjIwMCw0NTUuM3oiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
            background-size: 165%;
            height: 592px;
            background-repeat: no-repeat;
            opacity: 0.1;
        }
        .svg-light .svg23{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDIyMDAgNzQ0LjQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDIyMDAgNzQ0LjQ7IiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0ic3ZnIHJlcGxhY2VkLXN2ZyI+CiAgICAgICAgICAgICAgICAgICAgPGc+CiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGZpbGw9IiNmNGY0ZjQiIGQ9Ik0yMjAwLDUxMXYyMzMuNUgwVjBsMjQ4LjgsMTY0bDQ3Ni44LDQ1OC40bDE5MS40LTE4bDExMC45LDczLjFsNzEyLjQtMTM1LjEgICBDMTg2NS40LDUzNC4yLDIwOTIuOSw1MTguNCwyMjAwLDUxMXoiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICAgICAgPHBvbHlnb24gZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjQ3KSIgcG9pbnRzPSI5MTcsNjA0LjUgNzIxLjgsNjMzLjggMjQ4LjgsMTY0ICAiPjwvcG9seWdvbj4KICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjQ3KSIgZD0iTTIyMDAsNDU1LjN2ODIuNWMtMTE3LjEsMi43LTMzNC42LTMuNi00NTkuNyw0LjdMMjIwMCw0NTUuM3oiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgICAgICA8L3N2Zz4=);
        }
        .svg24{
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMzdweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiPjxwYXRoIGQ9Ik0wIDUxLjc2YzM2LjIxLTIuMjUgNzcuNTctMy41OCAxMjYuNDItMy41OCAzMjAgMCAzMjAgNTcgNjQwIDU3IDI3MS4xNSAwIDMxMi41OC00MC45MSA1MTMuNTgtNTMuNFYwSDB6IiBmaWxsLW9wYWNpdHk9Ii4zIi8+PHBhdGggZD0iTTAgMjQuMzFjNDMuNDYtNS42OSA5NC41Ni05LjI1IDE1OC40Mi05LjI1IDMyMCAwIDMyMCA4OS4yNCA2NDAgODkuMjQgMjU2LjEzIDAgMzA3LjI4LTU3LjE2IDQ4MS41OC04MFYwSDB6IiBmaWxsLW9wYWNpdHk9Ii41Ii8+PHBhdGggZD0iTTAgMHYzLjRDMjguMiAxLjYgNTkuNC41OSA5NC40Mi41OWMzMjAgMCAzMjAgODQuMyA2NDAgODQuMyAyODUgMCAzMTYuMTctNjYuODUgNTQ1LjU4LTgxLjQ5VjB6Ii8+PC9nPjwvc3ZnPg==);
            background-size: 133.33333333333% 337px;
            top: 0;
            height: 337px;
        }


        .curve-gray{
            background-image: url("data:image/svg+xml,%3C%3Fxml version='1.0' encoding='UTF-8'%3F%3E%3Csvg width='1921px' height='500px' viewBox='0 0 1921 500' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3C!-- Generator: Sketch 46 (44423) - http://www.bohemiancoding.com/sketch --%3E%3Ctitle%3ECombined Shape%3C/title%3E%3Cdesc%3ECreated with Sketch.%3C/desc%3E%3Cdefs%3E%3C/defs%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E%3Cpath d='M0.436525415,0 L0.421875,0 L0.421875,500 L1920.42187,500 L1920.42187,79.5156065 C1920.19367,79.4783576 1440.30771,1.15687371 960.421866,1.15687371 C480.421866,1.15687371 0.421988364,79.515625 0.421988364,79.515625 C0.421988364,79.515625 0.427635276,50.240852 0.436525415,3.40928018e-07 Z' id='Combined-Shape' fill='%23F5F9FC'%3E%3C/path%3E%3C/g%3E%3C/svg%3E");
        }
        .wave-white{
            background-image: url("data:image/svg+xml,%3C%3Fxml version='1.0' encoding='UTF-8'%3F%3E%3Csvg width='1921px' height='501px' viewBox='0 0 1921 501' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3C!-- Generator: Sketch 46 (44423) - http://www.bohemiancoding.com/sketch --%3E%3Ctitle%3ECombined Shape%3C/title%3E%3Cdesc%3ECreated with Sketch.%3C/desc%3E%3Cdefs%3E%3C/defs%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E%3Cpath d='M0.375,0.515625 L0.375,433.334048 C0.375,433.334048 520.375123,584.492596 960.375061,433.334048 C1400.375,282.175501 1920.375,433.334048 1920.375,433.334048 L1920.375,0.515625 L0.375,0.515625 Z' id='Combined-Shape' fill='%23FFFFFF' transform='translate(960.375000, 250.515625) scale(1, -1) translate(-960.375000, -250.515625) '%3E%3C/path%3E%3C/g%3E%3C/svg%3E");
        }
        .round-svg{
            background-image: url("data:image/svg+xml,%3Csvg height='1092.97' viewBox='0 0 1122 1092.97' width='1122' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m203.045 5274.89s208.36-182.76 441.994-141.93 705.911 647.35 530.931 901.27-382.5 189.02-567.438 141.83-597.283-290.27-502.6-467.09 64.618-288.64 66.16-339.45 30.953-94.63 30.953-94.63z' fill='%23fbf5f3' transform='translate(-92 -5127.03)'/%3E%3C/svg%3E");
            background-image: url("data:image/svg+xml,%0A%3Csvg height='1359.315' viewBox='0 0 1390.782 1359.315' width='1390.782' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m1357.38 1274.18c-184.91 83.78-252.72 149.65-374.139 148.26s-225.634-13.09-288.425-135.05-215.47-72.27-317.311-293.556c-57.162-124.207 57.05-280.351 115.682-413.476 45.83-104.056 44.8-246.089 168.45-346.14 281.848-228.052 453.663-162.28 453.663-162.28l637.4 519.544s-210.41 598.908-395.32 682.698z' fill='%23fbf5f3' fill-rule='evenodd' transform='translate(-361.938 -63.125)'/%3E%3C/svg%3E");
        }

    </style>
{/literal}


