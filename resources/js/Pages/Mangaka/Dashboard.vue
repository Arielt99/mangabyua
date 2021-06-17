<template>
    <mangaka-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        Dashboard Mangaka
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <!-- Header -->
                        <div>
                            <span>
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.mangas.length}}
                                </span>
                                Total mangas
                            </span>
                        </div>
                    </div>
                </div>
	        </main>
        </div>
    </mangaka-layout>
</template>

<script>
import MangakaLayout from '@/Layouts/MangakaLayout'
import moment from 'moment'

export default {
    props: ['mangas'],

    components: {
        MangakaLayout,
    },
    methods:{
        //date configuration with moment.js
        configDateTime(date) {
            return moment(date).locale("fr").format("Do MMM YYYY");
        },
    },
     beforeMount(){
        //  this.users.forEach(user => {
        //      console.log(user)
        //  });
    },
}
</script>
