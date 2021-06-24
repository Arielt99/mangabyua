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
                        <span>{{this.chapters.title}}’s informations</span>
                    </h2>
                    <div class="pb-2 flex items-center justify-between text-gray-600 dark:text-gray-400 border-b dark:border-gray-600">
                        <div class="flex ">
                            <span class="pr-5">
                                created
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.chapters.created_at)}}
                                </span>
                            </span>
                            <span class="pr-5">
                                last update
                                <span class="text-red-500 dark:text-red-200">
                                    {{configDateTime(this.chapters.updated_at)}}
                                </span>
                            </span>
                        </div>
                        <div class="flex">
                            <span @click="Delete()" class="w-7 bg-red-500 text-gray-200 rounded hover:bg-red-400 px-1 py-1 focus:outline-none mx-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current text-white" viewBox="0 0 64 64">
                                    <path data-name="layer2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M6 10h52m-36 0V5.9A3.9 3.9 0 0 1 25.9 2h12.2A3.9 3.9 0 0 1 42 5.9V10m10.5 0l-2.9 47.1a5 5 0 0 1-4.9 4.9H19.3a5 5 0 0 1-4.9-4.9L11.5 10" stroke-linejoin="round" stroke-linecap="round"></path>
                                    <path data-name="layer1" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" d="M32 18v36M22 18l2 36m18-36l-2 36" stroke-linejoin="round" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-1 sm:col-span-1">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Number</label>
                                        <p>n°{{this.chapters.number}}</p>
                                    </div>
                                    <div class="col-span-5 sm:col-span-5">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
                                        <p>{{this.chapters.title}}</p>
                                    </div>
                                    <div class="col-span-6 row-span-6 sm:col-span-6">
                                        <label for="cover" class="block text-sm font-medium text-gray-700">Pages</label>
                                        <div class="block grid grid-cols-6 gap-6 mx-auto my-4 mt-4 rounded-lg">
                                            <img v-for="media in this.chapters.medias" v-bind:key="media.id" :src="media.url" class="object-contain col-span-1 h-46" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </mangaka-layout>
    <jet-dialog-modal :show="this.ConfirmDeletion" @close="this.ConfirmDeletion = false">
        <template #title>
            Delete Chapter
        </template>

        <template #content>
            Are you sure you want to delete {{this.chapters.title}}? Once it is deleted, all of its resources and data will be permanently deleted.
        </template>

        <template #footer>
            <jet-secondary-button @click="ConfirmDeletion = false">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="deleteChapter" :class="{ 'opacity-25': delChapter.processing }" :disabled="delChapter.processing">
                Delete Chapter
            </jet-danger-button>
        </template>
    </jet-dialog-modal>
</template>
<script>
    import MangakaLayout from '@/Layouts/MangakaLayout'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ChapterCard from '@/Components/Mangaka/ChapterCard'
    import moment from 'moment'

    export default {
        components: {
            MangakaLayout,
            JetDialogModal,
            JetSecondaryButton,
            JetDangerButton,
            ChapterCard
        },

        props: ['mangas', 'chapters'],

        data () {
            return {
                ConfirmDeletion:false,

                delChapter: this.$inertia.form({
                    '_method': 'DELETE',
                },{
                    bag: 'deleteChapter'
                })
            }
        },

        methods:{
            Back() {
                window.history.back();
            },
            //date configuration with moment.js
            configDateTime(date) {
                return moment(date).locale("en").format("MMM Do YYYY");
            },
            Delete(){
                this.ConfirmDeletion = true
            },
            deleteChapter(){
                this.delChapter.post(route('mangaka.chapters.destroy', {manga: this.mangas.id, chapter: this.chapters.id}), {
                    preserveScroll: true
                })
            },
        },
        beforeMount(){
        //console.log(this.chapters);
        },
    }
</script>
