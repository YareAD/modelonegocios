<script setup>
import { ref, onBeforeMount } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps({
    requerimiento: Object,
    proyecto: Object,
});

const label = ref("Nuevo");
const form = useForm({
    id: -1,
    clave: "",
    descripcion: "",
    is_funcional: false,
    proyecto: props.proyecto.id,
});

const submit = () => {
    if (label.value === "Nuevo") {
        form.post(route("nuevo-requerimiento-post"), {
            onSuccess: (res) => {
                console.log(res);
            },
        });
    } else {
        form.post(route("update-requerimiento", { requerimiento: form.id }), {
            onSuccess: (res) => {
                console.log(res);
            },
        });
    }
};

onBeforeMount(() => {
    const r = props.requerimiento;
    if (r) {
        label.value = "Editar";
        form.id = r.id;
        form.clave = r.clave;
        form.descripcion = r.descripcion;
        form.is_funcional = r.is_funcional == 1;
    }
});
</script>
<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div class="w-full py-10">
            <div class="container mx-auto">
                <h1 class="text-2xl text-gray-600">
                    {{ label }} requerimiento
                </h1>
                <div
                    class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
                >
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="clave" value="Clave" />
                            <TextInput
                                id="clave"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.clave"
                                required
                                autofocus
                                autocomplete="clave"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.clave"
                            />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="descripcion" value="Descripcion" />
                            <TextAreaInput
                                rows="3"
                                id="descripcion"
                                class="mt-1 block w-full"
                                v-model="form.descripcion"
                                required
                                autocomplete="descripcion"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.descripcion"
                            />
                        </div>
                        <div class="mt-4">
                            <label class="flex items-center">
                                <Checkbox
                                    name="remember"
                                    v-model:checked="form.is_funcional"
                                />
                                <span class="ml-2 text-lg text-gray-600">
                                    Es requerimiento funcional
                                </span>
                            </label>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                type="submit"
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Guardar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
