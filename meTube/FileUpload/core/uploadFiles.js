var ZYFILE = {
		fileInput : null,             
		uploadInput : null,           
		dragDrop: null,				  
		url : "",  					  
		uploadFile : [],  			  
		lastUploadFile : [],          
		perUploadFile : [],           
		fileNum : 0,                  
		filterFile : function(files){ 
			return files;
		},
		onSelect : function(selectFile, files){      
			
		},
		onDelete : function(file, files){            
			
		},
		onProgress : function(file, loaded, total){  
			
		},
		onSuccess : function(file, responseInfo){    
			
		},
		onFailure : function(file, responseInfo){    
		
		},
		onComplete : function(responseInfo){         
			
		},
		
		/* 内部实现功能方法 */
		
		
		funDragHover: function(e) {
			e.stopPropagation();
			e.preventDefault();
			this[e.type === "dragover"? "onDragOver": "onDragLeave"].call(e.target);
			return this;
		},
		
		funGetFiles : function(e){  
			var self = this;
			
			this.funDragHover(e);
			
			var files = e.target.files || e.dataTransfer.files;
			self.lastUploadFile = this.uploadFile;
			this.uploadFile = this.uploadFile.concat(this.filterFile(files));
			var tmpFiles = [];
			
			
			var lArr = [];  
			var uArr = [];  
			$.each(self.lastUploadFile, function(k, v){
				lArr.push(v.name);
			});
			$.each(self.uploadFile, function(k, v){
				uArr.push(v.name);
			});
			
			$.each(uArr, function(k, v){
				
				if($.inArray(v, lArr) < 0){  
					tmpFiles.push(self.uploadFile[k]);
				}
			});
			
			
			
				this.uploadFile = tmpFiles;
			
			
			
			this.funDealtFiles();
			
			return true;
		},
		
		funDealtFiles : function(){
			var self = this;
			
			$.each(this.uploadFile, function(k, v){
				
				v.index = self.fileNum;
				
				self.fileNum++;
			});
			
			var selectFile = this.uploadFile;  
			
			this.perUploadFile = this.perUploadFile.concat(this.uploadFile);
			
			this.uploadFile = this.lastUploadFile.concat(this.uploadFile);
			
			
			this.onSelect(selectFile, this.uploadFile);
			console.info("Keep selecting");
			console.info(this.uploadFile);
			return this;
		},
		
		
		funDeleteFile : function(delFileIndex, isCb){
			var self = this;  
			
			var tmpFile = [];  
			
			var delFile = this.perUploadFile[delFileIndex];
			console.info(delFile);
			
			$.each(this.uploadFile, function(k, v){
				if(delFile != v){
					
					tmpFile.push(v);
				}else{
					
				}
			});
			this.uploadFile = tmpFile;
			if(isCb){  
				
				self.onDelete(delFile, this.uploadFile);
			}
			
			console.info("Files remain to upload:");
			console.info(this.uploadFile);
			return true;
		},
		
		funUploadFiles : function(){
			var self = this;  
			
			$.each(this.uploadFile, function(k, v){
				self.funUploadFile(v);
			});
		},
		
		funUploadFile : function(file){
			var self = this;  
			
			var formdata = new FormData();
			formdata.append("fileList", file);	         		
			var xhr = new XMLHttpRequest();
			
			
		    xhr.upload.addEventListener("progress",	 function(e){
		    	
		    	self.onProgress(file, e.loaded, e.total);
		    }, false); 
		    
		    xhr.addEventListener("load", function(e){
	    		
		    	self.funDeleteFile(file.index, false);
		    	
		    	self.onSuccess(file, xhr.responseText);
		    	if(self.uploadFile.length==0){
		    		
		    		self.onComplete("All done");
		    	}
		    }, false);  
		    
		    xhr.addEventListener("error", function(e){
		    	
		    	self.onFailure(file, xhr.responseText);
		    }, false);  
			
			xhr.open("POST",self.url, true);
			xhr.setRequestHeader("X_FILENAME", file.name);
			xhr.send(formdata);
		},
		
		funReturnNeedFiles : function(){
			return this.uploadFile;
		},
		
		
		init : function(){  
			var self = this;  
			
			if (this.dragDrop) {
				this.dragDrop.addEventListener("dragover", function(e) { self.funDragHover(e); }, false);
				this.dragDrop.addEventListener("dragleave", function(e) { self.funDragHover(e); }, false);
				this.dragDrop.addEventListener("drop", function(e) { self.funGetFiles(e); }, false);
			}
			
			
			if(self.fileInput){
				
				this.fileInput.addEventListener("change", function(e) {
					self.funGetFiles(e); 
				}, false);	
			}
			
			
			if(self.uploadInput){
				
				this.uploadInput.addEventListener("click", function(e) {
					self.funUploadFiles(e); 
				}, false);	
			}
		}
};

















