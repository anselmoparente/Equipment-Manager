<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';

import { Alerta } from '../../models/Alerta';
import { Equipamento } from '../../models/Equipamento';

const emit = defineEmits(['close']);

const props = defineProps({
    isOpen: { type: Boolean, required: true },
    equipment: { type: Equipamento },
});

const alerts = ref<Alerta[]>([]);

const close = () => {
    emit('close');
};

async function fetchAlerts() {
    try {
        const response = await axios.get('/alertas');
        alerts.value = response.data;
        console.log(alerts.value);
    } catch (error) {
        console.error('Erro ao buscar alertas:', error);
    }
};

onMounted(() => {
    fetchAlerts();
});
</script>

<template>
    <div v-if="isOpen" class="dialog-overlay" @click="close">
        <div class="dialog-container" @click.stop>
            <h2> Teste</h2>
        </div>
    </div>
</template>

<style scoped>
.dialog-container {
    background: white;
    border-radius: 8px;
    width: auto;
    overflow: hidden;
    padding: 32px;
    animation: fadeIn 0.3s ease-in-out;
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
</style>