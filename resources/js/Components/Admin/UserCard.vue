<template>
    <div class="mt-2 px-4 py-4 flex justify-between bg-white dark:bg-gray-600 shadow-xl rounded-lg">
        <!-- Card -->
        <div class="w-20 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>id</span>
            <span class="mt-2 text-black dark:text-gray-200">
                #{{user.id}}
            </span>
        </div>
        <div class="w-56 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>Name</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{user.first_name}} {{user.last_name}}
            </span>
        </div>
        <div class="w-56 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>username</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{user.username}}
            </span>
        </div>
        <div class="w-56 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>Email</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{user.email}}
            </span>
        </div>
        <div class="w-28 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>Roles</span>
            <div v-for="role in user.roles" v-bind:key="role.id" class="mt-2">
                <span class="mb-1 text-black dark:text-gray-200">
                    {{role.name}}
                </span>
            </div>
        </div>
        <div class="w-28 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>Status</span>
            <span class="mt-2 text-black dark:text-gray-200">
                None
            </span>
        </div>
        <div class="w-36 flex flex-col capitalize text-gray-600 dark:text-gray-400">
            <span>Inscription date</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{configDateTime(user.created_at)}}
            </span>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'

    export default {
        props: ['user'],

        methods:{
        //date configuration with moment.js
        configDateTime(date) {
            return moment(date).locale("fr").format("Do MMM YYYY");
        },
    },
    }
</script>
