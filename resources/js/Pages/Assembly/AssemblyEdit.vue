<script setup>
import {useForm} from "@inertiajs/inertia-vue3";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import SelectMenu from "../../Components/SelectMenu.vue";
import NavLink from "@/Components/NavLink.vue";
import {computed, ref} from "vue";

const props = defineProps({
  assembly: Object,
  manufacturers: Array,
  components: Array

});

const form = useForm({
  _method: "put",
  name: props.assembly.data.name,
  old_image: props.assembly.data.image,
  new_image: null,
  price: props.assembly.data.price,
  manufacturer_id: null,
  components: [],

});

const previewImageUrl = ref(props.assembly.data.image);
const selectedManufacturer = ref(props.manufacturers.find(item => item.id === props.assembly.data.manufacturer.id));
const assemblyComponents = computed(() => props.components.map(item => {
  const assemblyComponent = props.assembly.data.components.find(component => component.id === item.id);
  if (assemblyComponent === undefined) {
    return item;
  }
  return {...item, location: assemblyComponent.pivot.location, selected: true}
}));

const submit = () => {
  form.components = assemblyComponents.value.filter(value => value.selected);
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
          <BreezeInput @change="changePreviewImage" id="image" type="file" ref="photo" class="mt-1 block w-full"
                       @input="form.new_image = $event.target.files[0]"
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
          <SelectMenu label="Kies een fabriekant" :items="props.manufacturers" v-slot="manufacturer"
                      :selected-item="selectedManufacturer" v-model="selectedManufacturer">
                            <span class="font-normal block truncate">
                                {{ manufacturer.name }}
                            </span>
          </SelectMenu>
        </div>

        <div class="mt-4">
          <BreezeLabel value="Componenten"/>

          <ul class="overflow-y-auto px-1 pb-3 h-48 text-sm text-gray-700 dark:text-gray-200">
            <li v-for="component in assemblyComponents">
              <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                <input :id="'component.id-' + component.id" type="checkbox" v-model="component.selected"
                       :value="component"
                       class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                <label :for="'component.id-' + component.id"
                       class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{
                    component.name
                  }}</label>
                <div class="inline-flex">
                  <label
                      class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300">Locatie: </label>
                  <input :disabled="!component.selected" :required="component.selected" :value="component.location"
                         @input="event => component.location = event.target.value" class="block w-full border-2">
                </div>
              </div>
            </li>
          </ul>
        </div>

        <div class="flex items-center justify-between mt-4">
          <NavLink :href="route('assemblies.index')">
            <BreezeButton type="button" class="bg-blue-600" :class="{ 'opacity-25': form.processing }"
                          :disabled="form.processing">
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
