<template>
    <inertia-link :href="route('mangaka.mangas.show', {id: manga.id})">
        <div class="bg-gray-200 shadow-xl flex flex-col rounded-lg mx-auto overflow-hidden w-2/3">
            <img :src="manga.medias[0] ? manga.medias[0].url : '/img/imgPlaceholder.png' " class="object-cover bg-gray-200 mx-auto h-96 w-full" >
            <div class="px-4 py-4 flex justify-between bg-white dark:bg-gray-600">
                <!-- Card -->
                <div class="w-full flex flex-col text-gray-600 dark:text-gray-400 align-middle">
                    <span class="text-xl text-center truncate font-black uppercase text-black dark:text-gray-200">
                        {{manga.title}}
                    </span>
                </div>
            </div>
        </div>
    </inertia-link>
</template>
<script>
    import moment from 'moment'

    export default {
        components: {
        },
        props: ['manga'],

        data () {
            return {
            }
        },

        methods:{
            //date configuration with moment.js
            configDateTime(date) {
                return moment(date).locale("en").format("MMM Do YYYY");
            },
        },
    }
</script>
