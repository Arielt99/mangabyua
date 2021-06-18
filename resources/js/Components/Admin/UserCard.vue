<template>
    <div class="mt-2 px-4 py-4 flex justify-between bg-white dark:bg-gray-600 shadow-xl rounded-lg">
        <!-- Card -->
        <inertia-link :href="route('admin.users.show', {id: user.id})" class="w-20 flex flex-col text-gray-600 dark:text-gray-400">
            <span>id</span>
            <div class="mt-2 text-black dark:text-gray-200">
                #{{user.id}}
            </div>
        </inertia-link>
        <inertia-link :href="route('admin.users.show', {id: user.id})" class="w-56 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Name</span>
            <div class="mt-2 text-black dark:text-gray-200">
                {{user.full_name}}
            </div>
        </inertia-link>
        <inertia-link :href="route('admin.users.show', {id: user.id})" class="w-56 flex flex-col text-gray-600 dark:text-gray-400">
            <span>username</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{user.username}}
            </span>
        </inertia-link>
        <inertia-link :href="route('admin.users.show', {id: user.id})" class="w-56 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Email</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{user.email}}
            </span>
        </inertia-link>
        <div class="w-28 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Roles</span>
            <div v-for="role in user.roles" v-bind:key="role.id" class="mt-2">
                <span class="mb-1 text-black dark:text-gray-200">
                    {{role.name}}
                </span>
            </div>
        </div>
        <div class="w-36 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Inscription date</span>
            <span class="mt-2 text-black dark:text-gray-200">
                {{configDateTime(user.created_at)}}
            </span>
        </div>
        <div class="w-28 flex flex-col text-gray-600 dark:text-gray-400">
            <span>Actions</span>
            <div class="flex space-between">
                <span @click="Edit()" class="w-7 bg-yellow-500 text-gray-200 rounded hover:bg-yellow-400 px-1 py-1 focus:outline-none mx-1 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                        <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M56 2.4l-26.1 26-4 9.7 9.7-4.1 26-26L56 2.4z" stroke-linejoin="round" stroke-linecap="round"></path>
                        <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M34.4 11.6h-32v50h50v-32" stroke-linejoin="round" stroke-linecap="round"></path>
                        <path data-name="layer1" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M50.8 7.6l5.6 5.6" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </span>
                <span @click="Delete()" class="w-7 bg-red-500 text-gray-200 rounded hover:bg-red-400 px-1 py-1 focus:outline-none mx-1 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                        <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M6 10h52m-36 0V5.9A3.9 3.9 0 0 1 25.9 2h12.2A3.9 3.9 0 0 1 42 5.9V10m10.5 0l-2.9 47.1a5 5 0 0 1-4.9 4.9H19.3a5 5 0 0 1-4.9-4.9L11.5 10" stroke-linejoin="round" stroke-linecap="round"></path>
                        <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M32 18v36M22 18l2 36m18-36l-2 36" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </span>
            </div>
        </div>
    </div>
    <jet-dialog-modal :show="this.ConfirmDeletion" @close="this.ConfirmDeletion = false">
        <template #title>
            Delete User
        </template>

        <template #content>
            Are you sure you want to delete user {{this.user.username}}? Once it is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <jet-secondary-button @click="ConfirmDeletion = false">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteUser" :class="{ 'opacity-25': delUser.processing }" :disabled="delUser.processing">
                Delete User
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
</template>
<script>
    import moment from 'moment'
    import JetDialogModal from './../../Jetstream/DialogModal'
    import JetDangerButton from './../../Jetstream/DangerButton'
    import JetSecondaryButton from './../../Jetstream/SecondaryButton'

    export default {
        components: {
            JetDialogModal,
            JetSecondaryButton,
            JetDangerButton
        },
        props: ['user'],

        data () {
            return {
                ConfirmDeletion:false,

                delUser: this.$inertia.form({
                    '_method': 'DELETE',
                },{
                    bag: 'deleteUser'
                })
            }
        },

        methods:{
            //date configuration with moment.js
            configDateTime(date) {
                return moment(date).locale("en").format("MMM Do YYYY");
            },
            Edit(){
                this.$inertia.visit(route('admin.users.edit', {id: this.user.id}))
            },
            Delete(){
                this.ConfirmDeletion = true
            },
            deleteUser(){
                this.delUser.post(route('admin.users.destroy', {id: this.user.id}), {
                    preserveScroll: true
                })
            },
        },
    }
</script>
