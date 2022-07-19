<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const props = defineProps({
    component: Object
});

const form = useForm({
    _method: "put",
    name: props.component.data.name,
    type: props.component.data.type,
    old_image: props.component.data.image,
    new_image: null,
    price: props.component.data.price,
});

const previewImageUrl = ref(form.old_image);

const submit = () => {
    form.post(route('components.update', props.component.data.id));
};

const changePreviewImage = (e) => {
    const file = e.target.files[0];
    previewImageUrl.value = URL.createObjectURL(file);
};
</script>


<template>
    <div class="flex flex-col items-center mt-3 md:mt-6">
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
            <BreezeValidationErrors class="mb-4"/>
            <form @submit.prevent="submit">
                <div class="flex flex-wrap">
                    <BreezeLabel for="name" value="Component naam"/>
                    <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                 autofocus autocomplete="username"/>
                </div>
                <div class="mt-4">
                    <BreezeLabel for="name" value="Type"/>
                    <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.type" required
                                 autofocus autocomplete="type"/>
                </div>
                <div class="mt-4">
                    <BreezeLabel for="image" value="Afbeelding"/>
                    <BreezeInput @change="changePreviewImage" id="image" type="file" ref="photo" class="mt-1 block w-full" @input="form.new_image = $event.target.files[0]"
                                 autofocus autocomplete="image"/>
                    <img
                        v-if="previewImageUrl"
                        :src="previewImageUrl"
                        class="mt-4 h-80"
                        alt=""/>
                </div>
                <div class="mt-4">
                    <BreezeLabel for="price" value="Prijs"/>
                    <BreezeInput id="price" type="number" step="any" class="mt-1 block w-full" v-model="form.price" required
                                 autofocus autocomplete="price"/>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <NavLink :href="route('components.index')">
                        <BreezeButton type="button" class="bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Annuleer
                        </BreezeButton>
                    </NavLink>
                    <BreezeButton class="bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Bewerk component
                    </BreezeButton>
                </div>
            </form>
        </div>
    </div>
</template>
