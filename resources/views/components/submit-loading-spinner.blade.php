<div {{ $attributes }} style="color: white" class="float-right la-ball-clip-rotate pl-2">
    <div></div>
</div>

{{-- Style for submit loading spinner --}}
<style>
    .la-ball-clip-rotate,
    .la-ball-clip-rotate > div {
        position: relative;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
                box-sizing: border-box;
    }
    .la-ball-clip-rotate {
        width: 16px;
        height: 16px;
        display: none;
        font-size: 0;
        color: #fff;
    }
    
    .la-ball-clip-rotate > div {
        width: 16px;
        height: 16px;
        background: transparent;
        border-width: 3px;
        border-bottom-color: transparent;
        border-radius: 100%;
        -webkit-animation: ball-clip-rotate .75s linear infinite;
        -moz-animation: ball-clip-rotate .75s linear infinite;
            -o-animation: ball-clip-rotate .75s linear infinite;
                animation: ball-clip-rotate .75s linear infinite;
    }
    /*
    * Animation
    */
    @-webkit-keyframes ball-clip-rotate {
        0% {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        50% {
            -webkit-transform: rotate(180deg);
                    transform: rotate(180deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
        }
    }

    @keyframes ball-clip-rotate {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        50% {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                    transform: rotate(180deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                    transform: rotate(360deg);
        }
    }
</style>