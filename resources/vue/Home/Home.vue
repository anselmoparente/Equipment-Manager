<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

import { Equipamento } from '../../models/Equipamento';
import CreateDialog from '../components/CreateDialog.vue';

const equipments = ref<Equipamento[]>([]);
const isDialogOpen = ref<boolean>(false);

const atualizarSensores = async () => {
    try {
        // Chama a API para atualizar os sensores
        await axios.post('/api/sensor/atualizar');
        console.log('Sensores atualizados!');
        // Após a atualização, busca os equipamentos e sensores para exibição
        fetchEquipments();
    } catch (error) {
        console.error('Erro ao atualizar sensores:', error);
    }
};

const close = () => {
    isDialogOpen.value = false;
};

const openDialog = () => {
    isDialogOpen.value = true;
};

const fetchEquipments = async () => {
    try {
        const response = await axios.get('/equipamentos');
        equipments.value = response.data;

        console.log(equipments.value);
    } catch (error) {
        console.error('Erro ao buscar equipamentos:', error);
    }
};

function toggle(equipment: Equipamento) {
    const newStatus = equipment.status == true ? false : true;
    axios.post(`/api/equipments/${equipment.id}/toggle`, { status: newStatus })
        .then(() => {
            this.fetchEquipments();
        })
        .catch(error => console.error(error));
}

onMounted(() => {
    fetchEquipments();
    // Atualiza os sensores a cada 5 segundos
    // setInterval(atualizarSensores, 5000);
});
</script>

<template>
    <div class="background">
        <div class="content">
            <section class="area-section">
                <h1>Gerenciador de Equipamentos</h1>
                <button @click="openDialog">
                    <span class="material-symbols-outlined">add</span>
                    <p> Adicionar equipamento</p>
                </button>
            </section>
        </div>
        <div>
            <h2>Equipamentos</h2>
            <ul>
                <li v-for="equipment in equipments" :key="equipment.id">
                    <strong>{{ equipment.nome }}</strong> - Status: {{ equipment.status }}
                    <button @click="toggle(equipment)">{{ equipment.status == true ? 'Desligar' : 'Ligar' }}</button>

                    <!-- Lista de alarmes para o equipamento -->
                    <!-- <ul v-if="equipment. && equip.alarms.length">
                        <li v-for="alarm in equip.alarms" :key="alarm.id">
                            Alarme: {{ alarm.value }} em {{ alarm.created_at }}
                        </li>
                    </ul> -->
                </li>
            </ul>
        </div>
    </div>
    <CreateDialog :isOpen="isDialogOpen" @close="close"></CreateDialog>
</template>

<style scoped>
h1,
p {
    font-family: Montserrat;
    margin: 0;
}

h1 {
    color: #024C35;
    font-size: 32px;
    font-weight: 600;
}

p {
    font-size: 16px;
    font-weight: 500;
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
    justify-content: space-between;
    gap: 8px;
    margin: 0;
    padding: 8px;
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

.area-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding-block: 20px;
    padding-inline: 24px;
}

.background {
    background-color: #F0F5F2;
    display: flex;
    flex-direction: column;
    align-items: start;
    justify-content: end;
    height: 100vh;
}

.content {
    display: flex;
    flex-direction: column;
    padding: 32px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}
</style>