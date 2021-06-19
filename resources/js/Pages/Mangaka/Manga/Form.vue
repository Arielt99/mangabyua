<template>
    <mangaka-layout>
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
                        <span v-if="this.route().current('mangaka.mangas.create')">Manga creation</span>
                        <span v-if="this.route().current('mangaka.mangas.edit')">{{this.mangas.title}}’s modification</span>
                    </h2>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="submit">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-3 sm:col-span-3">
                                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" v-model="this.formManga.title" v-bind:class="{ error: this.formManga.errors.title}" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formManga.errors.title" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="mangakas" class="block text-sm font-medium text-gray-700">Mangakas</label>
                                            <multiselect v-model="this.formManga.mangakas" v-bind:class="{ error: this.formManga.errors.mangakas}" @change="mangakaSelect" name="mangakas" mode="tags" :options="this.mangakas" valueProp="id" :searchable="true" trackBy="full_name" label="full_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                            <jet-input-error :message="this.formManga.errors.mangakas" class="mt-2" />
                                        </div>

                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                            <multiselect v-model="this.formManga.tags" v-bind:class="{ error: this.formManga.errors.tags}" @change="tagSelect" name="tags" mode="tags" :options="this.tags" valueProp="id" :searchable="true" trackBy="name" label="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                                            <jet-input-error :message="this.formManga.errors.tags" class="mt-2" />
                                        </div>
                                        <div class="col-span-4 sm:col-span-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea v-model="this.formManga.description" v-bind:class="{ error: this.formManga.errors.description}" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                            <jet-input-error :message="this.formManga.errors.description" class="mt-2" />
                                        </div>
                                        <div class="col-span-2 sm:col-span-2">
                                        </div>
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="isMature" class="flex flex-row content-center text-sm font-medium text-gray-700 inline row">
                                                <input type="checkbox" v-model="this.formManga.isMature" @change="canBeUncheck" true-value=1 false-value=0 v-bind:class="{ error: this.formManga.errors.isMature}" name="isMature" id="isMature" class=" mr-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <p>Mature content</p>
                                            </label>
                                            <jet-input-error :message="this.formManga.errors.isMature" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <jet-action-message :on="this.formManga.recentlySuccessful" class="mr-3">
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
    </mangaka-layout>
</template>
<style src="@vueform/multiselect/themes/default.css"></style>

<script>
import JetActionMessage from './../../../Jetstream/ActionMessage'
import JetInputError from './../../../Jetstream/InputError'
import Multiselect from '@vueform/multiselect'
import MangakaLayout from '@/Layouts/MangakaLayout'
import moment from 'moment'

export default {
    props: {
        mangas: {
            type: Object,
            // Object or array defaults must be returned from
            // a factory function
            default() {
                return {
                    title: '',
                    mangakas:[],
                    tags: [],
                    description: '',
                    isMature: 0,
                }
            },
        },
        tags: Object,
        mangakas: Object,
    },
    components: {
        JetActionMessage,
        JetInputError,
        MangakaLayout,
        Multiselect
    },
    data () {
        return {
        formManga: this.$inertia.form({
                title: this.mangas.title,
                mangakas: this.mangas.mangakas,
                tags: this.mangas.tags,
                description: this.mangas.description,
                isMature: this.mangas.isMature
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
            if(this.route().current('mangaka.mangas.create')){
                this.formManga.post(this.route('mangaka.mangas.store'), {
                    preserveScroll: true,
                    onError: () => {
                    },
                    onSuccess: () => {

                    }
                })
            }
            else if(this.route().current('mangaka.mangas.edit')){
                this.formManga.put(this.route('mangaka.mangas.update', {id: this.mangas.id}), {
                    preserveScroll: true,
                    onError: () => {
                    },
                    onSuccess: () => {
                    }
                })
            }
        },
        //don't allow the current mangaka to not be in the mangaka list of the manga
        mangakaSelect(value){
            if(!value.includes(this.$page.props.user.id)){
                this.$nextTick(() => {
                    this.formManga.mangakas = this.formManga.mangakas.concat([this.$page.props.user.id])
                });
            }
        },
        //set the mature boolean to true if one of the tag have it
        tagSelect(value){
            let haveMatureTag
            value.forEach(choosedTagId => {
                    let chosenTag = this.tags.find(tag => tag.id === choosedTagId)
                    chosenTag.isMature ? haveMatureTag = 1 : null
                })
            if(haveMatureTag == 1){
                this.$nextTick(() => {
                    this.formManga.isMature = 1
                });
            }
        },
        //while wanting to uncheck, verify if any of the chossen tag is mature, and pprevent the uncheck if it's the case
        canBeUncheck(){
            let haveMatureTag
            this.formManga.tags.forEach(choosedTagId => {
                    let chosenTag = this.tags.find(tag => tag.id === choosedTagId)
                    chosenTag.isMature ? haveMatureTag = 1 : null
                })
            if(haveMatureTag == 1){
                this.$nextTick(() => {
                    this.formManga.isMature = 1
                });
            }
        }
    },
    mounted(){
        if(this.route().current('mangaka.mangas.create')){
            this.formManga.mangakas = this.formManga.mangakas.concat([this.$page.props.user.id])
        }
    },
}
</script>
<style>
.error{
    border: 1px red solid;
}
</style>
