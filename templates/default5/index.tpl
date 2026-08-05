{if $loggedin}
    {literal}
        <script>
            window.location.href='main';
        </script>
    {/literal}
{else}

    <div class="header-bottom  text-white" style="height:100vh">
        <div class="bg-svg2 svg24"></div>
        <div class="py-5">
            <div class="text-center  p-5">{if $logo} <img src="{$logo}"   />  {else} <h3> {$companyname}</h3>  {/if}</div>
            {include file="templates/default/login.tpl"}

            <div class="p-3 text-center  mt-5" style="z-index: 99">
                Not register? &nbsp; <i class="fal fa-arrow-right"></i>  &nbsp;
                <a class="btn bg-secondary px-3 py-1" data-toggle="modal" data-target="#modal-ajax" data-whatever="{$lang.registration}" data-size="modal-md" href="./{if !$seofriendly}index.php/{/if}register?standalone=true">
                    {$lang.registration}
                </a>
            </div>

        </div>
    </div>

    {literal}
        <style>
            .bg-svg,.bg-svg2{
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .svg24{
                background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIzMzdweCIgdmlld0JveD0iMCAwIDEyODAgMTQwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiPjxwYXRoIGQ9Ik0wIDUxLjc2YzM2LjIxLTIuMjUgNzcuNTctMy41OCAxMjYuNDItMy41OCAzMjAgMCAzMjAgNTcgNjQwIDU3IDI3MS4xNSAwIDMxMi41OC00MC45MSA1MTMuNTgtNTMuNFYwSDB6IiBmaWxsLW9wYWNpdHk9Ii4zIi8+PHBhdGggZD0iTTAgMjQuMzFjNDMuNDYtNS42OSA5NC41Ni05LjI1IDE1OC40Mi05LjI1IDMyMCAwIDMyMCA4OS4yNCA2NDAgODkuMjQgMjU2LjEzIDAgMzA3LjI4LTU3LjE2IDQ4MS41OC04MFYwSDB6IiBmaWxsLW9wYWNpdHk9Ii41Ii8+PHBhdGggZD0iTTAgMHYzLjRDMjguMiAxLjYgNTkuNC41OSA5NC40Mi41OWMzMjAgMCAzMjAgODQuMyA2NDAgODQuMyAyODUgMCAzMTYuMTctNjYuODUgNTQ1LjU4LTgxLjQ5VjB6Ii8+PC9nPjwvc3ZnPg==);
                background-size: 120% 550px;
                top: 0;
                height: 550px;
                z-index:0
            }
        </style>
    {/literal}

{/if}

