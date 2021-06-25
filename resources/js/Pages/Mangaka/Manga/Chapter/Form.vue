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
                        <span v-if="this.route().current('mangaka.chapters.create')">Chapter creation for {{this.mangas.title}}</span>
                        <span v-if="this.route().current('mangaka.chapters.edit')">{{this.chapters.title}}’s modification</span>
                    </h2>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="submit">
                            <div class="shadow h-auto overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-1 sm:col-span-1">
                                            <label for="number" class="block text-sm font-medium text-gray-700">Number</label>
                                            <input type="number" v-model="this.formChapter.number" min="0" step="0.01" v-bind:class="{ error: this.formChapter.errors.number}" name="number" id="number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formChapter.errors.number" class="mt-2" />
                                        </div>
                                        <div class="col-span-5 sm:col-span-5">
                                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" v-model="this.formChapter.title" v-bind:class="{ error: this.formChapter.errors.title}" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <jet-input-error :message="this.formChapter.errors.title" class="mt-2" />
                                        </div>
                                        <div class="col-span-6 row-span-6 sm:col-span-6">
                                            <label for="cover" class="block text-sm font-medium text-gray-700">Pages</label>
                                            <div class="flex mt-1 w-full items-center justify-center bg-grey-lighter">
                                                <label class="w-full flex flex-col items-center px-4 py-3 bg-white text-gray-500 rounded-lg tracking-wide uppercase border border-gray-300 cursor-pointer hover:text-gray-300" v-bind:class="{ error: this.formChapter.errors.medias}">
                                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                    </svg>
                                                    <span class="mt-1 text-base leading-normal">Select a file</span>
                                                    <input type='file' multiple accept="image/png, image/jpeg" class="hidden" @change="onFileChange" name="cover" id="cover"/>
                                                </label>
                                            </div>
                                            <div class="block grid grid-cols-6 gap-6 mx-auto my-4 mt-4 rounded-lg">
                                                <img v-for="(media, index) in this.formChapter.medias" v-bind:key="index" :src="toBlob(media)" class="object-contain col-span-1 h-46" >
                                            </div>
                                            <jet-input-error :message="this.formChapter.errors.medias" class="mt-2" />
                                        </div>

                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <jet-action-message :on="this.formChapter.recentlySuccessful" class="mr-3">
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
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetInputError from '@/Jetstream/InputError'
import Multiselect from '@vueform/multiselect'
import ChapterCard from '@/Components/Mangaka/ChapterCard'
import moment from 'moment'

export default {
    props: {
        chapters: {
            type: Object,
            // Object or array defaults must be returned from
            // a factory function
            default() {
                return {
                    title: '',
                    number: 0,
                    medias:[]
                }
            },
        },
        mangas: Object,
    },
    components: {
        JetActionMessage,
        JetInputError,
        ChapterCard,
        Multiselect
    },
    data () {
        return {
        value: [],
        formChapter: this.$inertia.form({
                title: this.chapters.title,
                number: this.mangas.chapters.length == 0 ? 0 : Math.floor(this.mangas.chapters[this.mangas.chapters.length-1].number) + 1,
                medias: this.chapters.media
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
            if(this.route().current('mangaka.chapters.create')){
                this.formChapter.post(this.route('mangaka.chapters.store', {manga: this.mangas.id}), {
                    preserveScroll: true,
                })
            }
            else if(this.route().current('mangaka.chapters.edit')){
                this.formChapter.put(this.route('mangaka.chapters.update', {manga: this.mangas.id, chapter: this.chapters.id}), {
                    preserveScroll: true,
                })
            }
        },
        onFileChange(fileInput) {
            if(fileInput.target.files[0]){
                this.formChapter.medias = fileInput.target.files;
            }
            else if(this.chapters.medias[0]){
                this.chapters.medias.forEach(media => this.formChapter.medias.push(media.url))
            }
            else{
                this.formChapter.medias = null
            }
        },
        toBlob(img){
            return URL.createObjectURL(img)
        },
    },
    beforeMount(){
        //console.log(this.mangas.chapters);
    },
}
</script>
<style>
.error{
    border: 1px red solid;
}
</style>
