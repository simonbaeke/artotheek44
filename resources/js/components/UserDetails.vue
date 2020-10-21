<template>
    <div class="columns is-mobile">
        <div class="column is-three-fifths is-offset-one-fifth">
            <form class="form">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Voornaam</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input readonly class="input" type="text" v-model="user.firstname">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Familienaam</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input readonly class="input" type="text" v-model="user.lastname">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Email</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input readonly class="input" type="text" v-model="user.email">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



</template>

<script>
    export default {
        name: "UserDetails",
        props:['user']
    }
</script>


<style scoped>
input[readonly]{
    border:none;
    border-bottom:1px solid hsl(0, 0%, 86%);
}
</style>
