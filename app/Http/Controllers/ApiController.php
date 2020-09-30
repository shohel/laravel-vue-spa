<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller {
	//


	public function saveNewPost( Request $request ) {
		if ( ! \auth()->check() ) {
			return [ 'success' => false, 'msg' => 'You must logged in to first to save any post' ];
		}
		$user_id = Auth::user()->id;

		$slug = unique_slug( $request->title );
		$data = [
			'user_id'      => $user_id,
			'title'        => $request->title,
			'slug'         => $slug,
			'post_content' => $request->post_content,
			'type'         => 'post',
		];

		/**
		 * Insert and attach tag with post if any
		 */
		$tags          = $request->tags;
		$attached_tags = [];
		if ( $tags ) {
			$tagsArr = explode( ',', $tags );
			foreach ( $tagsArr as $tag ) {
				$tag      = trim( $tag );
				$tag_slug = str_slug( $tag );
				$get_tag  = Tag::whereTagSlug( $tag_slug )->first();
				if ( $get_tag ) {
					$attached_tags[] = $get_tag->id;
				} else {
					$tag_data        = [
						'tag_name' => $tag,
						'tag_slug' => $tag_slug,
					];
					$tag_new         = Tag::create( $tag_data );
					$attached_tags[] = $tag_new->id;
				}
			}
		}

		$post_new = Post::create( $data );
		if ( count( $attached_tags ) ) {
			$post_new->tags()->attach( $attached_tags );
		}

		return [ 'success' => true ];
	}

	public function getPosts() {
		$posts         = Post::whereStatus( '1' )->with( [
			'user:id,name,user_name',
			'tags' => function ( $query ) {
				$query->select( 'tag_name', 'tag_slug' );
			},

		] )->orderBy( 'id', 'desc' )->paginate( 10 );
		$data['posts'] = $posts;

		return $data;
	}

	public function getTags() {
		$tags = Tag::select( 'tag_name', 'tag_slug' )->orderBy( 'tag_name', 'asc' )->get();

		return $tags;
	}

	public function getTagPosts( $slug ) {
		$tag = Tag::whereTagSlug( trim( $slug ) )->first();

		if ( $tag ) {
			$data['tag'] = $tag;

			$data['posts'] = $tag->posts()->whereStatus( '1' )->with( [
				'user:id,name,user_name',
				'tags' => function ( $query ) {
					$query->select( 'tag_name', 'tag_slug' );
				},
			] )->orderBy( 'id', 'desc' )->paginate( 10 );

			return [ 'success' => true, 'data' => $data ];
		}

		return [ 'success' => false, 'msg' => "There is no posts exists attached [{$slug}]" ];
	}

	public function getSinglePost( $slug = null ) {
		$post = Post::whereSlug( $slug )->first();

		if ( $post ) {
			$postArr = $post->toArray();

			return [ 'success' => true, 'post' => $postArr ];
		}

		return [ 'success' => false, 'msg' => "Post not found" ];
	}

	public function getAuthorPosts( $user_name ) {
		$user = User::whereUserName( $user_name )->first();

		if ( $user ) {
			$data['user'] = $user;

			$data['posts'] = $user->posts()->whereStatus( '1' )->with( [
				'user:id,name,user_name',
				'tags' => function ( $query ) {
					$query->select( 'tag_name', 'tag_slug' );
				},
			] )->orderBy( 'id', 'desc' )->paginate( 10 );

			return [ 'success' => true, 'data' => $data ];
		}

		return [ 'success' => false, 'msg' => "There is no posts exists attached [{$user_name}]" ];
	}

	/**
	 * @param  Request  $request
	 *
	 * @return array
	 *
	 * Check username availability
	 */

	function checkUserNameAvailability( Request $request ) {
		$user_name = strtolower( $request->user_name );
		if ( $user_name ) {
			$count = User::whereUserName( $user_name )->first();
			if ( ! $count ) {
				return [ 'success' => true, 'msg' => 'User Name has been valid' ];
			}

			return [ 'success' => false, 'msg' => 'User Name has been taken already' ];
		}

		return [ 'success' => false, 'msg' => 'Something went wrong, Please try again later' ];
	}

	/**
	 * @param  Request  $request
	 *
	 * Save User
	 */
	public function userRegister( Request $request ) {
		$rules = [
			'name'      => 'required',
			'user_name' => 'required',
			'email'     => 'required',
			'password'  => 'required|confirmed',
		];

		$this->validate( $request, $rules );
		$user_name      = str_slug( $request->user_name );
		$duplicate_find = User::where( 'user_name', $request->user_name )->orWhere( 'email', $request->email )->first();
		if ( $duplicate_find ) {
			return [ 'success' => false, 'msg' => 'User Name or email has already been used' ];
		}

		$user_data              = array_except( $request->input(), 'password_confirmation' );
		$user_data['user_name'] = $user_name;
		$user_data['password']  = Hash::make( $request->password );


		$user = User::create( $user_data );
		if ( $user ) {
			Auth::login( $user, true );

			return [ 'success' => true, 'msg' => 'User has been created successfully' ];
		}

		return [ 'success' => false, 'msg' => 'Something went wrong, please try again later' ];
	}

	/**
	 *
	 * Get Logged out and return to home
	 */
	public function logout() {
		Auth::logout();

		return [ 'success' => true, 'msg' => 'Successfully Logged Out' ];
	}

	public function signIn( Request $request ) {
		$credential = array_only( $request->input(), [ 'email', 'password' ] );
		if ( Auth::attempt( $credential, $request->remember ) ) {
			return [ 'success' => true, 'msg' => 'Authenticated successfully' ];
		}

		return [ 'success' => false, 'msg' => 'Email or password is not valid' ];
	}


	public function getUsersOfficePosts() {
		$user = Auth::user();

		$data = $user->posts()->with( [
			'user:id,name,user_name',
			'tags' => function ( $query ) {
				$query->select( 'tag_name', 'tag_slug' );
			},
		] )->orderBy( 'id', 'desc' )->paginate( 10 );


		return [ 'success' => true, 'data' => $data ];
	}


	public function getAllPosts() {
		$user = Auth::user();

		if ( $user->is_admin() ) {
			$data = Post::with( [
				'user:id,name,user_name',
				'tags' => function ( $query ) {
					$query->select( 'tag_name', 'tag_slug' );
				},
			] )->orderBy( 'id', 'desc' )->paginate( 10 );

			return [ 'success' => true, 'data' => $data ];
		}

		return [ 'success' => false, 'data' => 'You are not allowed to view this page' ];
	}

	public function postStatusChange( Request $request ) {
		$user = Auth::user();

		if ( $user->is_admin() ) {
			$post         = Post::find( $request->post_id );
			$post->status = $request->status;
			$post->save();

			return [ 'success' => true, 'data' => 'Post status has been changed' ];
		}

		return [ 'success' => false, 'data' => 'You are not allowed to do this operation' ];
	}

}
