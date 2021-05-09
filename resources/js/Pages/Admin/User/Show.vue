<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        <span>{{this.user.username}}'s profile</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <div>
                            <span class="pr-5">
                                created
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.user.created_at)}}
                                </span>
                            </span>
                            <span class="pr-5">
                                last update
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.user.updated_at)}}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </admin-layout>
</template>
<script>
import AdminLayout from '@/Layouts/AdminLayout'
import moment from 'moment'

export default {
    components: {
        AdminLayout
    },

    props: ['user'],

    methods:{
        //date configuration with moment.js
        configDateTime(date) {
            return moment(date).locale("en").format("MMM Do YYYY");
        },
    },
}
</script>
