<template>
    <div>
        <div class="loader"></div>
        <p class="loadertext">
            Loadink...
        </p>
    </div>

</template>

<script>
    export default {
        name: "LoadingIndicator",
        mounted() {
        },

        created() {

        }


    }
</script>

<style scoped>
    .loader,
    .loader:before,
    .loader:after {
        background: #eeeeee;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
    }

    .loader {
        color: #eeeeee;
        text-indent: -9999em;
        margin: 88px auto;
        position: fixed;
        top: 20rem;
        left: calc(((100vw + 240px) / 2));
        transform: translateX(-50%);

        font-size: 11px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }

    .loader:before,
    .loader:after {
        color: #eeeeee;

        position: absolute;
        top: 0;
        content: '';
    }

    .loader:before {
        left: -1.5em;
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }

    .loader:after {
        left: 1.5em;
    }

    @-webkit-keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }

    @keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }

    .loadertext {
        color: #AeAeAe;
        position:absolute;
        top: 27rem;
        left: calc(((100vw - 240px) / 2));
        transform: translateX(-50%);
    }
</style>
