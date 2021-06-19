<template>
    <admin-layout>
        <div class="h-screen w-full flex overflow-hidden">
            <main class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition duration-500 ease-in-out overflow-y-auto">
                <div class="mx-10 my-2">
                    <h2 class="my-4 flex flex-row text-4xl font-semibold dark:text-gray-400">
                        <a href="#" class="pr-3 flex content-center" @click="Back">
                            <svg viewBox="0 0 64 64" class="w-7 fill-current" xmlns="http://www.w3.org/2000/svg" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke="#202020" fill="none" d="M3 46h44a15 15 0 0 0 15-15 15 15 0 0 0-15-15H2" data-name="layer2" stroke-linejoin="round"></path>
                                <path d="M16 34L3 46l13 12" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke="#202020" fill="none" data-name="layer1" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <span v-if="this.route().current('admin.users.create')">User creation</span>
                        <span v-if="this.route().current('admin.users.edit')">{{this.users.username}}’s modification</span>
                    </h2>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="submit">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-3 sm:col-span-3">
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                                            <input type="text" v-model="this.formUser.first_name" v-bind:class="{ error: this.formUser.errors.first_name}" name="first_name" id="first_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.first_name" class="mt-2" />
                                        </div>
                                        <div class="col-span-3 sm:col-span-3">
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                            <input type="text" v-model="this.formUser.last_name" v-bind:class="{ error: this.formUser.errors.last_name}" name="last_name" id="last_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.last_name" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                            <input type="text" v-model="this.formUser.username" v-bind:class="{ error: this.formUser.errors.username}" name="username" id="username" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.username" class="mt-2" />
                                        </div>

                                        <div class="col-span-2 sm:col-span-2">
                                            <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                                            <input type="date" v-model="this.formUser.birthday" v-bind:class="{ error: this.formUser.errors.birthday}" name="birthday" id="birthday" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.birthday" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                            <input type="email" v-model="this.formUser.email" v-bind:class="{ error: this.formUser.errors.email}" name="email" id="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.email" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="roles" class="block text-sm font-medium text-gray-700">Roles</label>
                                            <multiselect v-model="this.formUser.roles" v-bind:class="{ error: this.formUser.errors.roles}" name="roles" mode="tags" :options="this.roles" valueProp="id" :searchable="true" trackBy="name" label="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                            <jet-input-error :message="this.formUser.errors.roles" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" v-model="this.formUser.password" v-bind:class="{ error: this.formUser.errors.password}" name="password" id="password" ref="password" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formUser.errors.password" class="mt-2" />
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Password confirmation</label>
                                            <input type="password" v-model="this.formUser.password_confirmation" v-bind:class="{ error: this.formUser.errors.password}" name="password_confirmation" id="password_confirmation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <jet-action-message :on="this.formUser.recentlySuccessful" class="mr-3">
                                        Saved.
                                    </jet-action-message>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
	        </main>
        </div>
    </admin-layout>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>

<script>
import JetActionMessage from './../../../Jetstream/ActionMessage'
import JetInputError from './../../../Jetstream/InputError'
import Multiselect from '@vueform/multiselect'
import AdminLayout from '@/Layouts/AdminLayout'
import moment from 'moment'

export default {
    props: {
        users: {
            type: Object,
            // Object or array defaults must be returned from
            // a factory function
            default() {
                return {
                    first_name: '',
                    last_name: '',
                    username: '',
                    birthday: '',
                    roles: [],
                    email: '',
                    password: '',
                    password_confirmation: '',
                }
            },
        },
        roles: Object,
    },
    components: {
        JetActionMessage,
        JetInputError,
        AdminLayout,
        Multiselect
    },
    data () {
        return {
        formUser: this.$inertia.form({
                first_name: this.users.first_name,
                last_name: this.users.last_name,
                username: this.users.username,
                birthday: moment(this.users.birthday).format('YYYY-MM-DD'),
                roles: this.users.roles,
                email: this.users.email,
                password: this.users.password,
                password_confirmation: this.users.password_confirmation,
            })
        }

    },
    methods:{
        Back() {
            window.history.back();
        },
        //date configuration with moment.js
        configDateTime(date) {
            return moment(date).locale("fr").format("Do MMM YYYY");
        },
        submit() {
            if(this.route().current('admin.users.create')){
                var tempBirthday = this.formUser.birthday
                this.formUser.birthday = new Date(this.formUser.birthday)
                if (!isNaN(this.formUser.birthday)){
                    this.formUser.birthday = tempBirthday

                }
                this.formUser.post(this.route('admin.users.store'), {
                    preserveScroll: true,
                    onError: () => {
                        this.formUser.birthday = tempBirthday
                        if(this.formUser.errors.password){
                            this.formUser.password = '';
                            this.formUser.password_confirmation = '';
                            this.$refs.password.focus()
                        }
                    },
                    onSuccess: () => {
                            this.formUser.password = '';
                            this.formUser.password_confirmation = '';
                    }
                })
            }
            else if(this.route().current('admin.users.edit')){
                var tempBirthday = this.formUser.birthday
                this.formUser.birthday = new Date(this.formUser.birthday)
                if (!isNaN(this.formUser.birthday)){
                    this.formUser.birthday = tempBirthday

                }
                this.formUser.put(this.route('admin.users.update', {id: this.users.id}), {
                    preserveScroll: true,
                    onError: () => {
                        this.formUser.birthday = tempBirthday
                        if(this.formUser.errors.password){
                            this.formUser.password = '';
                            this.formUser.password_confirmation = '';
                            this.$refs.password.focus()
                        }
                    },
                    onSuccess: () => {
                        this.formUser.password = '';
                        this.formUser.password_confirmation = '';
                    }
                })
            }
        }
    },
}
</script>
<style>
.error{
    border: 1px red solid;
}
</style>
