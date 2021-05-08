<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main
                class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition
                duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        User list
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
                        <div>
                            <span class="capitalize ml-12">
                                role
                                <span
                                    class="text-green-500 dark:text-green-200
                                    cursor-pointer">
                                    all
                                </span>
                            </span>
                        </div>

                    </div>
                    <div
                        class="mt-6 flex justify-between text-gray-600 dark:text-gray-400">
                        <!-- List sorting -->

                        <div class="ml-10 pl-2 flex capitalize">
                            <!-- Left side -->
                            <span class="ml-8 flex items-center">
                                name
                                <svg
                                    class="ml-1 h-5 w-5 fill-current text-green-500
                                    dark:text-green-200"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>
                            <span class="ml-24 flex items-center">
                                login
                                <svg
                                    class="ml-1 h-5 w-5 fill-current"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>
                        </div>

                        <div class="mr-12 flex capitalize">
                            <!-- Right side -->

                            <span class="mr-16 pr-1 flex items-center">
                                Email
                                <svg
                                    class="ml-1 h-5 w-5 fill-current"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>

                            <span class="mr-16 pr-2 flex items-center">
                                Roles
                                <svg
                                    class="ml-1 h-5 w-5 fill-current"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>

                            <span class="mr-12 flex items-center">
                                Status
                                <svg
                                    class="ml-1 h-5 w-5 fill-current"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>
                            <span class="mr-16 flex items-center">
                                Inscription date
                                <svg
                                    class="ml-1 h-5 w-5 fill-current"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2
                                        19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                                </svg>
                            </span>
                        </div>

                    </div>
                    <div v-for="user in this.users" v-bind:key="user.id">
                        <div
                            class="mt-2 flex px-4 py-4 justify-between bg-white
                            dark:bg-gray-600 shadow-xl rounded-lg cursor-pointer ">
                            <!-- Card -->
                            <div class="flex justify-between">
                                <!-- Left side -->

                                <img
                                    class="h-12 w-12 rounded-full object-cover"
                                    src="https://picsum.photos/200"
                                    alt="" />

                                <div
                                    class="ml-4 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>name</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                        {{user.first_name}} {{user.last_name}}
                                    </span>
                                </div>

                                <div
                                    class="ml-12 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>username</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                        {{user.username}}
                                    </span>

                                </div>

                            </div>

                            <div class="flex">
                                <!-- Rigt side -->

                                <div
                                    class="mr-16 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>Email</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                        {{user.email}}
                                    </span>
                                </div>

                                <div
                                    class="mr-16 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>Roles</span>
                                    <div v-for="role in user.roles" v-bind:key="role.id">
                                        <span class="mt-2 text-black dark:text-gray-200">
                                            {{role.name}}
                                        </span>
                                    </div>
                                </div>

                                <div
                                    class="mr-16 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>Status</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                        None
                                    </span>
                                </div>

                                <div
                                    class="mr-8 flex flex-col capitalize text-gray-600
                                    dark:text-gray-400">
                                    <span>Inscription date</span>
                                    <span class="mt-2 text-black dark:text-gray-200">
                                        {{configDateTime(user.created_at)}}
                                    </span>
                                </div>

                            </div>

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
