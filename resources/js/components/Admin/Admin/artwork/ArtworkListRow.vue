<template>
    <tr>
        <td v-on:click="showDetails(props.item)">{{ props.item.name }}</td>
        <td>{{ artwork.artist.fullname }}</td>
        <td>{{ artwork.code}}</td>
        <td>{{ artwork.available? "beschikbaar" : "Niet beschikbaar"}}</td>
        <td><icon>remove_outline</icon></td>
    </tr>
</template>

<script>
    export default {
        name: "ArtworkListRow",
        props:['artwork']
    }
</script>

<style scoped>

</style>
