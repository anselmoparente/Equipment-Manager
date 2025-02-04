<script setup lang="ts">
import { ref } from 'vue';
import Header from '../../components/Header.vue'
import OptionItem from './components/OptionItem.vue';
import Tooltip from '../../components/Tooltip.vue';

const logoULabs = ref('/src/assets/logo_ulabs_green.svg');

const options = ref([
    {
        title: 'Gerenciar Disciplinas',
        iconTitle: 'list',
        subtitle: 'Visualize e edite informações das disciplinas dos seus cursos',
        buttonLabel: 'Visualizar Disciplinas',
        url: 'manageDiscipline.index',
    },
    {
        title: 'Disponibilidade dos Professores',
        iconTitle: 'calendar_month',
        subtitle: 'Defina a disponibilidade de horários dos professores para o semestre',
        buttonLabel: 'Definir Disponibilidade',
        url: 'teacherAvailability.index',
    },
    {
        title: 'Atribuir Professores à Disciplinas',
        iconTitle: 'add_link',
        subtitle: 'Defina os professores responsáveis por cada disciplina',
        buttonLabel: 'Atribuir Professores',
        url: 'association.index',
    },
]);

declare function route(name: string): string;

function navigateTo(url: string) {
    window.location.href = route(url);
}
</script>

<template>
    <div class="background">
        <Header></Header>
        <div class="content">
            <section class="area-section">
                <p>Área do Coordenador</p>
                <Tooltip
                    message="Bem-vindo(a) ao Painel do Coordenador! Aqui, você pode gerenciar informações importantes relacionadas aos cursos e disciplinas. Clique em uma das opções abaixo para começar.">
                </Tooltip>
            </section>
            <section class="options-section">
                <OptionItem v-for="(option, index) in options" :key="index" :title="option.title"
                    :iconTitle="option.iconTitle" :subtitle="option.subtitle" :buttonLabel="option.buttonLabel"
                    @click="navigateTo(option.url)">
                </OptionItem>
            </section>
            <section class="creator">
                <p class="body">Criado por</p>
                <img :src="logoULabs" alt="Logo verde do ULabs" />
            </section>
        </div>
    </div>
</template>

<style scoped>
p {
    color: #032826;
    font-family: Montserrat;
    font-size: 32px;
    font-weight: 600;
    margin: 0;
}

span {
    color: #B0B8B3;
    font-size: 32px;
}


.area-section {
    background-color: white;
    border: 1px solid #B0B8B3;
    border-radius: 24px;
    display: flex;
    flex-direction: row;
    align-items: center;
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

.body {
    color: #032826;
    font-size: 14px;
    font-weight: 500;
}

.content {
    display: flex;
    flex-direction: column;
    padding: 32px;
    height: 100%;
    width: 100%;
    box-sizing: border-box;
}

.creator {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: auto;
    gap: 8px;
    box-sizing: border-box;
    width: 100%;
    height: auto;
}

.creator p {
    margin: 0;
    padding: 0;
    height: auto;
    width: auto;
}

.creator img {
    max-width: 100%;
    height: auto;
}


.options-section {
    display: flex;
    flex-direction: row;
    gap: 24px;
    margin-top: 24px;
}
</style>