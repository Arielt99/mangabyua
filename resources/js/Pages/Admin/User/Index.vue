<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        <span v-if="route().params['roles'] == 'Mangaka'">Mangakas</span>
                        <span v-else-if="route().params['roles'] == 'Reader'">Readers</span>
                        <span v-else>Accounts</span>
                        <span> List</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <!-- Header -->
                        <div>
                            <span v-if="route().params['roles'] != 'Mangaka'  && route().params['roles'] != 'Reader'" class="pr-5">
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.users.length}}
                                </span>
                                Total Users
                            </span>
                            <span v-if="route().params['roles'] != 'Reader'" class="pr-5">
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.users.filter(user => user.roles.find(role => role.name == "Mangaka")).length}}
                                </span>
                                Mangakas
                            </span>
                            <span v-if="route().params['roles'] != 'Mangaka'" class="pr-5">
                                <span class="text-red-500 dark:text-red-200">
                                    {{this.users.filter(user => user.roles.find(role => role.name == "Reader")).length}}
                                </span>
                                Readers
                            </span>
                        </div>
                        <div>
                            <input type="search" v-model="search" placeholder="Search a user.." class="inline-flex items-center px-3 py-2 my-2 mx-1 rounded-md font-semibold text-xs"/>
                            <button id="add" @click="Add" class="inline-flex items-center px-3 py-2 my-2 mx-1 ml-10 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">Create a User</button>
                        </div>
                    </div>
                    <div class="mt-2 flex px-4 justify-between text-gray-600 dark:text-gray-400 capitalize">
                        <!-- List sorting -->
                        <div @click="this.sort == 'asc.id' ? Sort('desc.id') : Sort('asc.id')" class="w-20 flex items-center">
                            <span>id</span>
                            <svg v-if="this.sort == 'asc.id'" class="ml-1 h-5 w-5 fill-current text-red-500 dark:text-red-200" viewBox="0 0 24 24">
                                <path d="M18 21l-4-4h3V7l2 0v10h3M 2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                            </svg>
                            <svg v-else-if="this.sort == 'desc.id'" class="ml-1 h-5 w-5 fill-current text-red-500 dark:text-red-200" viewBox="0 0 24 24">
                                <path d="M17 17V7h-3l4-4l4 4h-3v10h3M2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>

                            </svg>
                            <svg v-else class="ml-1 h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path d="M18 21l-4-4h3V7h-3l4-4 4 4h-3v10h3M2 19v-2h10v2M2 13v-2h7v2M2 7V5h4v2H2z"></path>
                            </svg>
                        </div>
                    </div>
                    <user-card v-for="user in this.UserList" v-bind:key="user.id" v-bind:user="user"/>
                    <p v-if="this.UserList.length == 0" class="w-auto m-auto text-center">No user to display</p>
                </div>
	        </main>
        </div>
    </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import UserCard from '@/Components/Admin/UserCard'

export default {
    components: {
        AdminLayout,UserCard
    },

    props: ['users'],

    data() {
        return {
            sort:null,
            search:''
        };
    },

    methods: {
        Add(){
            this.$inertia.visit(route('admin.users.create'))
        },
        Sort(parameter){
            switch (parameter) {
                case 'asc.id':
                        this.UserList.sort(function(a, b) {
                            return a.id - b.id;
                        });
                        this.sort = parameter
                    break;
                case 'desc.id':
                        this.UserList.sort(function(a, b) {
                            return a.id - b.id;
                        }).reverse();
                        this.sort = parameter
                    break;
                default:
                    this.sort = null
                    console.log(`Sorry, we are out of ${parameter}.`);
            }
        }
    },

    computed:{
        UserList() {
            var results = [];
            for(var i=0; i<this.users.length; i++) {
                var matching = false;
                for(var key in this.users[i]) {
                    if(key=="last_name"||key=="first_name"||key=="username"||key=="email"){
                        if(this.users[i][key] != null && this.users[i][key].indexOf(this.search.toLowerCase())!=-1) {
                            matching = true;
                        }
                    }
                }
                if(matching == true){
                    results.push(this.users[i]);
                }
            }
            return results;
        },
    },
}
</script>

