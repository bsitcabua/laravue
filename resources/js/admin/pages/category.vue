<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<div class="_overflow">
						<p class="_title0 pull-left">Categories</p>
						<Button @click="showAddModal()" class="pull-right mb-2"><Icon type="md-add" /> Add category</Button>
					</div>
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Category name</th>
								<th style="text-align: center;">Photo</th>
								<th>Created at</th>
								<th style="text-align: center;">Action</th>
							</tr>
								<!-- TABLE TITLE -->
								<!-- ITEMS -->
							<tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
								<td>{{++i}}</td>
								<td class="_table_name">{{category.categoryName}}</td>
								<td>
									<img :src = "`/uploads/${category.iconImage}`" alt="Photo" v-bind:style="{ width: '40px', height: '40px', margin: 'auto' }">
								</td>
								<td>{{ category.created_at | moment("MMMM DD YYYY, h:mm:ss a") }}</td>
								<td style="text-align: center;">
									<Button type="info" size="small" @click="showEditModal(category, i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(category, i)">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
				</div>


				<!-- category adding modal -->
				<Modal
					v-model="addModal"
					title="Add category"
					:mask-closable="false"
					:closable="false"
				>
					<form @submit="storeCategories" v-on:submit.prevent>
						<Input v-model="data.categoryName" placeholder="Add category name"  />
						<br />
						<br />
						<Upload
							
							accept="image/*"
							type="drag"
							:headers="{'x-csrf-token': CSRFTOKEN}"
							:on-success="handleSuccess"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
							:on-remove="handleRemove"
							action="/api/upload-category">
							<div style="padding: 20px 0">
								<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
								<p>Click or drag files here to upload</p>
							</div>
						</Upload>
						<div class="image_thumb" v-if="data.iconImage">
							<img :src = "`/uploads/${data.iconImage}`" alt="">
						</div>

					</form>
					<div slot="footer">
						<Button type="default" @click="addModal=false">Close</Button>
						<Button type="primary" @click="storeCategories" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add category'}}</Button>
					</div>
				</Modal>
				<!-- category editing modal -->
				<Modal
					v-model="editModal"
					title="Edit category"
					:mask-closable="false"
					:closable="false"
					>
					<form @submit="editCategory" v-on:submit.prevent>
						<Input v-model="editData.categoryName" placeholder="Edit category name"  />
						<br />
						<br />
						<Upload
							
							accept="image/*"
							type="drag"
							:headers="{'x-csrf-token': CSRFTOKEN}"
							:on-success="handleSuccess"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
							:on-remove="handleRemove"
							action="/api/upload-category">
							<div style="padding: 20px 0">
								<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
								<p>Click or drag files here to upload</p>
							</div>
						</Upload>
						<div>
							<div class="image_thumb" v-if="editData.iconImageTemp">
							<img :src = "`/uploads/${editData.iconImageTemp}`" alt="">
							</div>
							<div class="image_thumb" v-else>
								<img :src = "`/uploads/${editData.iconImage}`" alt="">
							</div>
						</div>
					</form>
					<div slot="footer">
						<Button type="default" @click="editModal=false">Close</Button>
						<Button type="primary" @click="editCategory" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing..' : 'Edit category'}}</Button>
					</div>

				</Modal>
				<!-- delete alert modal -->
				<Modal v-model="showDeleteModal" width="360">
					<p slot="header" style="color:#f60;text-align:center">
						<Icon type="ios-information-circle"></Icon>
						<span>Delete confirmation</span>
					</p>
					<div style="text-align:center">
						<p>Are you sure you want to delete category?</p>
						<b>{{ deleteItem.categoryName }}</b>
					</div>
					<div slot="footer">
						<Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory" >{{ isDeleting ? "Deleting..." : "Delete" }}</Button>
					</div>
				</Modal>
				

			</div>
		</div>
    </div>
</template>


<script>
export default {
	data(){
		return {
			data : {
				iconImage: '',
				categoryName: ''
			}, 
			addModal : false, 
			editModal : false, 
			isAdding : false,
			isEditing : false,
			categories : [], 
			editData : {
				categoryName: '',
				conImage: '',
				iconImageTemp: '',
			}, 
			index : -1, 
			showDeleteModal: false, 
			isDeleting : false,
			deleteItem: {},
			CSRFTOKEN: '',

		}
	},

	methods : {
		async getCategories () {
			const res = await this.callApi('get', 'api/categories');
			const data = await res.data;
			if(data.status == 200){
				this.categories = data.categories;
			}else{
				this.swr();
			}
		},

		async storeCategories(){
			if(this.data.categoryName.trim()=='') return this.error('Category name is required.', 'Required Field');
			this.isAdding = true;
			const res = await this.callApi('post', 'api/store-category', this.data);
			const data = await res.data;
			if (data.status === 201) {
				this.categories = data.categories;
				this.success(data.msg);
				this.addModal = false;
				this.data.categoryName = '';
			} else {
				if ( data.status == 422 && data.validator.categoryName) {
					this.error(data.validator.categoryName[0], 'Required Field');
				}
				else if( data.status == 409 ) {
					this.error(data.msg, 'Already Exist');
				} 
				else {
					this.swr(data.msg);
				}
			}
			this.isAdding = false;

		},
		async editCategory(){
			if(this.editData.categoryName.trim()=='') return this.error('Category name is required.', 'Required Field');
			this.isEditing = true;
			const res = await this.callApi('post', 'api/update-category', this.editData);
			const data = await res.data;
			if(data.status == 201){
				this.categories = data.categories;
				this.success(data.msg);
				this.editModal = false
			}else{
				if ( data.status == 422 && data.validator.categoryName) {
					this.error(data.validator.categoryName[0], 'Required Field');
				}
				else if( data.status == 409 ) {
					this.error(data.msg, 'Already Exist');
				} 
				else {
					this.swr(data.msg);
				}
			}
			this.isEditing = false;

		},
		showAddModal () {
			this.addModal = true;
			this.categoryName = '';

		},
		showEditModal(category, index){
			let obj = {
				id : category.id,
				categoryName : category.categoryName,
				iconImage : category.iconImage
			}
			this.editData = obj;
			this.editModal = true;
			this.index = index;

		}, 
		async deleteCategory(){
			this.isDeleting = true
			const res = await this.callApi('post', 'api/destroy-category', this.deleteItem);
			const data = await res.data;
			if(data.status == 200){
				this.categories = data.categories;
				this.success(data.msg);
				// this.success('category has been deleted successfully!');
				this.showDeleteModal = false
			}else{
				this.swr()
			}
			this.isDeleting = false
			
		}, 
		showDeletingModal(category, i){
			this.deleteItem = category;
			this.showDeleteModal = true;
		},
		handleSuccess (res, file) {
			if (res.status === 201) {
				this.data.iconImage = res.fileName;
				this.editData.iconImageTemp = res.fileName;
			} else {
				
				if ( res.status == 422 && res.validator.file) {
					this.error(res.validator.file[0], 'Upload failed');
				}
				else {
					this.swr(res.msg);
				}
			}
		},
		handleFormatError (file) {
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
			});
		},
		handleMaxSize (file) {
			this.$Notice.warning({
				title: 'Exceeding file size limit',
				desc: 'File  ' + file.name + ' is too large, no more than 2M.'
			});
		},
		handleRemove (file) {
			this.data.iconImage = '';
			this.editData.iconImageTemp = '';
		},
	}, 

	created(){
		this.CSRFTOKEN = window.Laravel.csrfToken;
		// Call function categories
		this.getCategories();
	}


	
}
</script>