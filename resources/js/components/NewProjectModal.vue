<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl">Create a new project</h1>

        <div class="flex">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label for="title" class="text-sm block mn-2">Title</label>
                    <input type="text" id="title" class="border border-muted-light p-2 text-xs block w-full rounded">
                </div>

                <div class="mb-4">
                    <label for="description" class="text-sm block mn-2">Description</label>
                    <textarea type="text" id="description" class="border border-muted-light p-2 text-xs block w-full rounded" rows="7"></textarea>
                </div>
            </div>

            <div class="flex-1 ml-4">
                <div class="mb-4">
                    <label class="text-sm block mn-2">Need some Tasks ?</label>
                    <input type="text" placeholder="Task 2" class="border border-muted-light p-2 text-xs block w-full rounded">
                </div>

                <button type="button" class="inline-flex items-center text-xs" @click="addTask()">
                    <svg class="mr-2" viewbox="0 0 18 18" height="18" width="18">
                        <g fill="#000" fill-rule="evenodd" opacity=".307">
                            <path fill="#000" d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"></path>
                        </g>
                    </svg>
                </button>

                <footer class="flex justify-end">
                    <button class="button mr-4 bg-white" @click="$modal.hide('new-project')">Cancel</button>
                    <button class="button">Create project</button>
                </footer>
            </div>
        </div>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [

                ]
            }
        },

        methods: {
            addTask() {

            }
        }
    }
</script>