<template>
    <inertia-link :href="route('mangaka.chapters.show', {manga: mangas.id, chapter: chapter.id})" class="mt-2 px-4 py-4 flex justify-between bg-white dark:bg-gray-600 shadow-xl rounded-lg">
        <!-- Card -->
        <div class="w-20 flex flex-col text-gray-600 dark:text-gray-400">
            <div class="mt-2 text-black dark:text-gray-200">
                n°{{chapter.number}}
            </div>
        </div>
        <div class="w-3/4 flex flex-col text-gray-600 dark:text-gray-400">
            <div class="mt-2 text-black dark:text-gray-200">
                {{chapter.title}}
            </div>
        </div>
        <div class="w-30 flex flex-col text-gray-600 dark:text-gray-400">
            <span class="mt-2 text-green dark:text-gray-200">
                {{configDateTime(chapter.created_at)}}
            </span>
        </div>
    </inertia-link>
</template>
<script>
    import moment from 'moment'

    export default {
        components: {
        },
        props: ['chapter', 'mangas'],

        data () {
            return {
            }
        },

        methods:{
            //date configuration with moment.js
            configDateTime(date) {
                return moment(date).locale("en").fromNow();
            },
        },
    }
</script>
