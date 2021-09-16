<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!--Inicio do card de busca-->
                <card-component titulo="Busca de Marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component
                                    id="inputId"
                                    titulo="ID"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do registro."
                                >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="inputId"
                                        aria-describedby="idHelp"
                                        placeholder="ID"
                                    />
                                </input-container-component>
                            </div>
                            <div class=" col mb-3">
                                <input-container-component
                                    id="inputNome"
                                    titulo="Nome"
                                    id-help="nomeHelp"
                                    texto-ajuda="Opcional. Informe o nome da marca."
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="inputNome"
                                        aria-describedby="nomeHelp"
                                        placeholder="Nome da marca"
                                    />
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                        >
                            Pesquisar
                        </button>
                    </template>
                </card-component>
                <!--Fim do card de busca-->

                <!--Inicio do card de listagem de marcas-->
                <card-component titulo="Relação de Marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button
                            type="submit"
                            class="btn btn-primary btn-sm float-right"
                            data-toggle="modal"
                            data-target="#idModal"
                        >
                            Adicionar
                        </button>
                    </template>
                </card-component>
                <!--Fim do card de listagem de marcas-->
                <modal-component id="idModal" titulo="Adicionar Marca">
                    <template v-slot:conteudo>
                        <div class="form-group">
                            <input-container-component
                                id="novoNome"
                                titulo="Nome da Marca"
                                id-help="novonomeHelp"
                                texto-ajuda="Informe o nome da marca."
                            >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="novoNome"
                                    aria-describedby="novonomeHelp"
                                    placeholder="Nome da marca"
                                />
                            </input-container-component>
                            <input-container-component
                                id="novaImagem"
                                titulo="Imagem"
                                id-help="novaImagemHelp"
                                texto-ajuda="Seleciona uma imagem."
                            >
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="novaImagem"
                                    aria-describedby="novaImagemHelp"
                                    placeholder="Seleciona uma imagem."
                                />
                            </input-container-component>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Fechar
                        </button>
                        <button type="button" class="btn btn-primary">
                            Salvar
                        </button>
                    </template>
                </modal-component>
            </div>
        </div>
    </div>
</template>
<script>
import InputContainer from "./InputContainer.vue";
export default {
    components: { InputContainer }
};
</script>
