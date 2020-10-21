<template>

    <form action="#" class="flexnavigation__search">
        <input v-model="searchString" type="text" class="flexnavigation__search__input"
               >
               <!--v-bind:placeholder="searchplaceholder">-->
        <button class="flexnavigation__search__button" v-on:click="onSearch">
<!--            <svg class="flexnavigation__search__icon">
                <use xlink:href="icons/sprite.svg#icon-magnifying-glass"></use>
            </svg>-->
            <ion-icon name="search" class="icon"></ion-icon>
        </button>
    </form>

</template>

<script>
    import {eventBus} from "./../app.js";

    export default {
        name: "Navigation",
        props: ["searchplaceholder"],
        data() {
            return {
                searchString: "",
            }
        },
        methods: {
            onSearch() {
                eventBus.$emit('onSearch', this.searchString);
            }
        }

    }
</script>

<style scoped>
    .navbar-link:hover {
        background-color: transparent;
    }

    .navbar-link:active {
        background-color: transparent;
    }

    .is-hoverable {
        background-color: transparent;
    }
</style>
