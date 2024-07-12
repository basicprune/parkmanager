<?php //echo $model_form; 
?>
<style>
    .SelectedMap{
        margin-left: 45%;
        width: 30% !important;
        height: 30% !important;
    }
    
</style>
<div v-cloak id="app">
    <div class="panel">
        <h3>New Attachment</h3>
        <form method="POST" @submit.prevent="">
            <div class="small-12 medium-12 large-12">
                <label>
                    <input type="file" id="file" ref="file" @change="prepareFile()" />
                </label>
                 <!--<br>
                <div v-if="can_restrict == 'true'">
                            <label class="cmfive__checkbox-container">Restricted
                                <input type="checkbox" v-model="is_restricted">
                                <span class="cmfive__checkbox-checkmark"></span>
                            </label>
                            <div v-show="is_restricted"><strong>Select the users that can view this attachment</strong>
                                <ul class="small-block-grid-1 medium-block-grid-3 large-block-grid-3">
                                    <li v-for="viewer in viewers" style="padding-bottom: 0;">
                                        <label class="cmfive__checkbox-container">{{ viewer.name }}
                                            <input type="checkbox" v-model="viewer.can_view">
                                            <span class="cmfive__checkbox-checkmark" ></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div> 
            </div><br> -->
            <!-- <button class="small" style="margin-bottom: 0rem;" @click="uploadFile()">Save</button> -->
        </form>
    </div>
</div>

<?php echo $table; ?>
<div style="margin-left: 52%;">current Map</div>

<div class="SelectedMap" ><?php echo $selectedmap; ?></div>

        <script>
            var app = new Vue({
                el: "#app",
                data: function() {
                    return {
                        can_restrict: "<?php echo false; ?>",
                        viewers: <?php echo empty($viewers) ? json_encode([]) : $viewers; ?>,
                        title: null,
                        description: null,
                        file: null,
                        is_restricted: false,
                        max_upload_size: "<?php echo FileService::getInstance($w)->getMaxFileUploadSize() ?: ( 2 * 1024 * 1024);?>",
                        class: "<?php echo $class; ?>",
                        class_id: "<?php echo $class_id; ?>",
                        redirect_url: "<?php echo $redirect_url; ?>",
                    }
                    
                },
                methods: {
                    
                    prepareFile: function() {
                        this.file = this.$refs.file.files[0];
                        
                    },
                    
                    uploadFile: function() {
                        
                        if (this.file === null) {
                            new Toast("No file selected").show();
                            return;
                        }
                        
                        if (this.file.size > this.max_upload_size) {
                            console.log(this.file.size);
                            console.log(this.max_upload_size);
                            new Toast("File size is too large").show();
                            return;
                        }
                       
                        toggleModalLoading();

                        var file_data = {
                            title: this.title,
                            description: this.description,
                            class: this.class,
                            class_id: this.class_id,
                            is_restricted: this.is_restricted,
                            viewers: this.viewers.filter(function(viewer) {
                                return viewer.can_view;
                            })
                        };
                        
                        var form_data = new FormData(); 
                        form_data.append("file", this.file);
                        form_data.append("file_data", JSON.stringify(file_data));
                        console.log(file_data);
                        
                        
                        //console.log(testHellol);
                        
                        
                        
                        ///system/templates/js/es6-promise.auto.js
                        axios.post("/file-attachment/ajaxAddAttachment", 
                            form_data, {
                                headers: {
                                    "Content-Type": "multipart/form-data"
                                }
                            }
                        ).then(function(response) {
                            console.log(form_data);
                            window.history.go();
                           
                            
                        }).catch(function(error) {
                            console.log(error);
                            new Toast("Failed to upload file").show();
                            
                        }).finally(function() {
                            hideModalLoading();
                            
                            
                        });
                        
                        
                    }
                    
                }
                
            });
        </script>


