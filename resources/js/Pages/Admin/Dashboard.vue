<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main
                class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition
                duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        Dashboard
                    </h2>
                    <div
                        class="pb-2 flex items-center justify-between text-gray-600
                        dark:text-gray-400 border-b dark:border-gray-600">
                        <!-- Header -->

                        <div>
                            <span>
                                <span class="text-green-500 dark:text-green-200">
                                    {{this.users.length}}
                                </span>
                                Total Users;
                            </span>
                            <span>
                                <span class="text-green-500 dark:text-green-200">
                                    {{this.users.filter(user => user.roles.find(role => role.name == "Mangaka")).length}}
                                </span>
                                Mangakas;
                            </span>
                            <span>
                                <span class="text-green-500 dark:text-green-200">
                                    {{this.users.filter(user => user.roles.find(role => role.name == "Reader")).length}}
                                </span>
                                Readers
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
    props: ['users'],

    components: {
        AdminLayout,
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
