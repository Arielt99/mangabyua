<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                        <span>{{this.user.username}}'s profile</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <div class="flex ">
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
                        <div class="flex">
                            <span class="w-7 bg-yellow-500 text-gray-200 rounded hover:bg-yellow-400 px-1 py-1 focus:outline-none mx-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                                    <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M56 2.4l-26.1 26-4 9.7 9.7-4.1 26-26L56 2.4z" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M34.4 11.6h-32v50h50v-32" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer1" fill="none" stroke="#202020" stroke-miterlimit="10" stroke-width="2" d="M50.8 7.6l5.6 5.6" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </span>
                            <span @click="Delete()" class="w-7 bg-red-500 text-gray-200 rounded hover:bg-red-400 px-1 py-1 focus:outline-none mx-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                                    <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M6 10h52m-36 0V5.9A3.9 3.9 0 0 1 25.9 2h12.2A3.9 3.9 0 0 1 42 5.9V10m10.5 0l-2.9 47.1a5 5 0 0 1-4.9 4.9H19.3a5 5 0 0 1-4.9-4.9L11.5 10" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M32 18v36M22 18l2 36m18-36l-2 36" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 px-4 py-4 flex flex-col bg-white dark:bg-gray-600 shadow-xl rounded-lg">
                        <span class="flex flex-row justify-around">
                            <t>Last name : {{this.user.last_name}}</t>
                            <t>First name : {{this.user.first_name}}</t>
                        </span>
                        <span class="flex flex-row justify-around">
                            <t>Username : {{this.user.username}}</t>
                            <t>Email : {{this.user.email}}</t>
                        </span>
                        <div class="flex flex-row justify-around">
                            <span>
                                Roles :
                                <t v-for="role in this.user.roles" v-bind:key="role.id">
                                    {{role.name}}
                                </t>
                            </span>
                            <t>Birthday : {{configDateTime(this.user.birthday)}}</t>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </admin-layout>
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
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetDialogModal from './../../../Jetstream/DialogModal'
    import JetDangerButton from './../../../Jetstream/DangerButton'
    import JetSecondaryButton from './../../../Jetstream/SecondaryButton'
    import moment from 'moment'

    export default {
        components: {
            AdminLayout,
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

            Delete(){
                this.ConfirmDeletion = true
            },
            deleteUser(){
                this.delUser.post(route('admin.user.destroy', {id: this.user.id}), {
                    preserveScroll: true
                })
            },
        },
    }
</script>
