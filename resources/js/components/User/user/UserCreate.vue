<template>

    <div class="mdl-cell mdl-cell--10-col mdl-cell--0-offset-phone mdl-cell--1-offset-desktop mdl-cell--0-offset-tablet">
        <div class="demo-card-square mdl-card mdl-shadow--2dp">

            <div class="mdl-card__title mdl-card--expand">
                <h2 class="mdl-card__title-text">Nieuwe gebruiker</h2>
            </div>
            <div class="mdl-card__supporting-text">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-textfield__label" for="firstname">Voornaam</label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <input class="mdl-textfield__input" type="text" id="firstname"
                               name="firstname" v-model="user.firstname">
                    </div>
                </div>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-textfield__label" for="lastname">Familienaam</label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <input class="mdl-textfield__input" v-model="user.lastname" type="text" id="lastname"
                               name="lastname">
                    </div>
                </div>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-textfield__label" for="email">Email</label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <input class="mdl-textfield__input" v-model="user.email" type="email" id="email"
                               name="email">
                    </div>
                </div>
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">

                        <label class="mdl-textfield__label" for="email">Admin</label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                            <input type="checkbox" id="switch-1" class="mdl-switch__input" checked>
                            <span class="mdl-switch__label"></span>
                        </label>
                    </div>
                </div>


            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "UserCreate",
        data() {
            return {
                user: {
                    firstname: "",
                    lastname: "",
                    email: ""
                }
            }
        }
    }
</script>

<style scoped>
    .mdl-card {
        width: 100%;
    }

    .mdl-textfield__label {
        position: inherit;
    }
</style>
