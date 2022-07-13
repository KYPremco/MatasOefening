<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import SelectMenu from "../../Components/SelectMenu.vue";
import NavLink from "@/Components/NavLink.vue";
import {ref} from "vue";

const props = defineProps({
    assembly: Object,
    manufacturers: Array
});

const form = useForm({
    _method: "put",
    name: props.assembly.data.name,
    old_image: props.assembly.data.image,
    new_image: null,
    price: props.assembly.data.price,
    manufacturer_id: props.assembly.data.manufacturer.id
});

const selectedManufacturer = ref(props.manufacturers.find(item => item.id === props.assembly.data.manufacturer.id));
const previewImageUrl = ref(form.old_image);

const submit = () => {
    form.manufacturer_id = selectedManufacturer.value.id;
    form.post(route('assemblies.update', props.assembly.data.id));
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
                    <BreezeLabel for="name" value="Assemblage naam"/>
                    <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                 autofocus autocomplete="username"/>
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
                <div class="mt-4">
                    <SelectMenu label="Kies een fabriekant" :items="props.manufacturers" v-slot="manufacturer" :selected-item="selectedManufacturer" v-model="selectedManufacturer">
                            <span class="font-normal block truncate">
                                {{ manufacturer.name }}
                            </span>
                    </SelectMenu>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <NavLink :href="route('assemblies.index')">
                        <BreezeButton type="button" class="bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Annuleer
                        </BreezeButton>
                    </NavLink>
                    <BreezeButton class="bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Bewerk assemblage
                    </BreezeButton>
                </div>
            </form>
        </div>
    </div>
</template>
