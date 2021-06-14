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
                        <span v-if="this.route().current('admin.tags.create')">Tag creation</span>
                        <span v-if="this.route().current('admin.tags.edit')">{{this.tags.name}}’s modification</span>
                    </h2>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="submit">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" v-model="this.formTag.name" v-bind:class="{ error: this.formTag.errors.name}" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formTag.errors.name" class="mt-2" />
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                            <input type="text" v-model="this.formTag.slug" v-bind:class="{ error: this.formTag.errors.slug}" name="slug" id="slug" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formTag.errors.slug" class="mt-2" />
                                        </div>
                                        <div class="col-span-2 sm:col-span-2">
                                        </div>
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="isMature" class="flex flex-row content-center text-sm font-medium text-gray-700 inline row">
                                                <input type="checkbox" v-model="this.formTag.isMature" true-value=1 false-value=0 v-bind:class="{ error: this.formTag.errors.isMature}" name="isMature" id="isMature" class=" mr-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <p>Mature content</p>
                                            </label>
                                            <jet-input-error :message="this.formTag.errors.isMature" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <jet-action-message :on="this.formTag.recentlySuccessful" class="mr-3">
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
        tags: {
            type: Object,
            // Object or array defaults must be returned from
            // a factory function
            default() {
                return {
                    name: '',
                    slug: '',
                    isMature: false,
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
        value: [],
        formTag: this.$inertia.form({
                name: this.tags.name,
                slug: this.tags.slug,
                isMature: this.tags.isMature,
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
            if(this.route().current('admin.tags.create')){
                this.formTag.post(this.route('admin.tags.store'), {
                    preserveScroll: true,
                })
            }
            else if(this.route().current('admin.tags.edit')){
                this.formTag.put(this.route('admin.tags.update', {id: this.tags.id}), {
                    preserveScroll: true,
                    onSuccess: () => this.formTag.slug = this.$page.props.tags.slug,
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
