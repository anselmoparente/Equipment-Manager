<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['close']);

defineProps({
    isOpen: { type: Boolean, required: true },
});

const nome = ref<string>('');
const parametro = ref<string>('');
const limite_min = ref<number>(0);
const limite_max = ref<number>(0);

const close = () => {
    nome.value = '';
    parametro.value = '';
    limite_min.value = 0;
    limite_max.value = 0;
    emit('close');
};

async function criarEquipamento() {
    try {
        await axios.post('/equipamentos', {
            nome: nome.value,
            parametro: parametro.value,
            limite_min: limite_min.value,
            limite_max: limite_max.value,
        });
    } catch (error) {
        console.error(error);
    }
};

</script>

<template>
    <div v-if="isOpen" class="dialog-overlay" @click="close">
        <div class="dialog-container" @click.stop>
            <h2>Adicionar Equipamento</h2>
            <form @submit.prevent="criarEquipamento">
                <div class="dialog-field">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" v-model="nome" required />
                </div>
                <div class="dialog-field">
                    <label for="parametro">Parâmetro</label>
                    <input type="text" id="parametro" v-model="parametro" required />
                </div>
                <div class="dialog-field">
                    <label for="limite_min">Limite Mínimo</label>
                    <input type="number" id="limite_min" v-model="limite_min" required />
                </div>
                <div class="dialog-field">
                    <label for="limite_max">Limite Máximo</label>
                    <input type="number" id="limite_max" v-model="limite_max" required />
                </div>
                <button type="submit">
                    <p>Adicionar</p>
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
h2,
p,
label,
input {
    font-family: Montserrat;
    margin: 0;
}

h2 {
    color: #024C35;
    font-size: 1.5rem;
    font-weight: 700;
}

p {
    font-size: 16px;
    font-weight: 500;
}

label {
    color: #024C35;
}

form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

button {
    background-color: white;
    border: 2px solid #F6741C;
    border-radius: 12px;
    color: #F6741C;
    cursor: pointer;
    text-align: center;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin: 0;
    padding-block: 12px;
}

button:hover {
    background-color: #F6741C;
    color: white;
}

button:active {
    background-color: #D35614;
    border: 2px solid #D35614;
    color: white;
}

.dialog-container {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 32px;
    padding: 32px;
}

.dialog-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.dialog-field label {
    font-size: 16px;
    font-weight: 500;
}

.dialog-field input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.dialog-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.message {
    color: green;
    margin-top: 10px;
}
</style>