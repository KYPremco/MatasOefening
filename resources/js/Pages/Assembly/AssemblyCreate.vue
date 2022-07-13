<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import {ref} from "vue";
import SelectMenu from "../../Components/SelectMenu.vue";
import NavLink from "@/Components/NavLink.vue";


const props = defineProps({
    manufacturers: Array
});

const form = useForm({
    name: null,
    image: null,
    price: null,
    manufacturer_id: null
});

const submit = () => {
    form.manufacturer_id = selectedManufacturer.value.id;
    form.post(route('assemblies.store'), {
        // onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const changePreviewImage = (e) => {
    const file = e.target.files[0];
    previewImageUrl.value = URL.createObjectURL(file);
};

const previewImageUrl = ref(null);
const selectedManufacturer = ref();
</script>

<template>
    <div class="flex flex-col items-center mt-3 md:mt-6">
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md sm:rounded-lg">
            <BreezeValidationErrors class="mb-4"/>

            <form @submit.prevent="submit">
                <div>
                    <BreezeLabel for="name" value="Assemblage naam"/>
                    <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                 autofocus autocomplete="username"/>
                </div>
                <div class="mt-4">
                    <BreezeLabel for="image" value="Afbeelding"/>
                    <BreezeInput @change="changePreviewImage" id="image" type="file" ref="photo"
                                 class="mt-1 block w-full" @input="form.image = $event.target.files[0]" required
                                 autofocus autocomplete="image"/>
                    <img
                        v-if="previewImageUrl"
                        :src="previewImageUrl"
                        class="mt-4 h-80"
                        alt=""/>
                </div>
                <div class="mt-4">
                    <BreezeLabel for="price" value="Prijs"/>
                    <BreezeInput id="price" type="number" step="any" class="mt-1 block w-full" v-model="form.price"
                                 required
                                 autofocus autocomplete="price"/>
                </div>
                <div class="mt-4">
                    <SelectMenu label="Kies een fabriekant" :items="props.manufacturers" v-slot="manufacturer" v-model="selectedManufacturer">
                            <span class="font-normal block truncate">
                                {{ manufacturer.name }}
                            </span>
                    </SelectMenu>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <NavLink :href="route('assemblies.index')">
                        <BreezeButton type="button" class="bg-blue-600" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Ga terug
                        </BreezeButton>
                    </NavLink>
                    <BreezeButton class="ml-4 bg-blue-600" :class="{ 'opacity-25': form.processing }"
                                  :disabled="form.processing">
                        Maak assemblage
                    </BreezeButton>
                </div>

            </form>
        </div>
    </div>
</template>

<style scoped>
</style>
