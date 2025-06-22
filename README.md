<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 1. **models:**

- ### **authentication system:**
	- #### user:
	     attributes :
		 -  name (string) 
		 - email (unique | email )
		 - password (verification | min:4 )
- ### **discovering Expo :**
	- #### 1. company
	attributes :
    - name ( required |max: 15 letter |string)
	- description ( required | min: 15 word | max: 50 word)
	- phone (numeric)
	- image (required | image |nullable | mimes : jpeg , jpg , png )
	- #### 2. product
	attribute:
	- name ( string | max: 255)
	- description (min: 5 letter | max: 255)
	- image (image |nullable | mimes : jpeg , jpg , png )
- ### 3. registration:
	- #### 1. lecture 
	attributes :
    	- title (max: 15 letter )
        - description (min: 15 word | max: 50 word)
        - date (date->{ex:2025-08-01 05:01:11})
        - place 
        - mentor (string)
        - location (string)

    - #### 2. workshop
	attribute:
	- name
	- description
	- date
	- mentor
	- location

## 2. **Relations:** 
1. user : 
	 - belongs to many lectures
	 - belongs to many workshops
2. companies :
	 - has many products
3. lectures :
	- belongs to many
4. workshops :
	- belongs to many 
5. products : 
	- belongs to company

## 3. **resources :**
	
 1. User Resource :
	
 - to show the user name and email :
	
           {
			"user" :
				"id" => $this->id,  
					"name" => $this->name,  
					"email" => $this->email,
			}
	
2. Company Resource :
	
 - to show the company's name , desc , phone , tags , image url :
 
            {
			    "company" :
					"id" => $this->id,  
						"name" => $this->name,  
						"description" => $this->description
						"phone" =>$this->phone
						"image_url" => $this->getFirstImageUrl()
					"products" =>
						[
						{
						"id": 1,
						"name": "web application",
					    "desc": "making aweswome web application for traddings porpose",
					    "imageUrl": "http://localhost:8000/storage/2/My_photo.jpg"
						},
						{
						"id": 2,
						"name": "web application",
					    "desc": "making aweswome web application for traddings porpose",
					    "imageUrl": "http://localhost:8000/storage/2/My_photo.jpg"
						}
						]
			}          
	
3. Product Resource :

      - to show the product's name , desc , imageurl and company information :

       {
	   "product":
		"id" =>$this->id,
		"name" => $this->name,
		"desc" => $this->desc,
		"imageurl"=> $this->getfirstimageurl(), 
	   }
