import {ApiController} from "@/core/ApiController";
import {NextRequest, NextResponse} from "next/server";
import ApiResponse from "@/core/ApiResponse";

export default class AuthApiController extends ApiController implements CRUDApiMethods{
	constructor(request: NextRequest, response: NextResponse) {
		super(request, response);
	}

	async index() {
		try {
			const query = await this.getReqData()
			return ApiResponse.success(query)
		}catch (e) {
			return ApiResponse.error(e)
		}
	}

	async create() {
		try {
			const requestData = await this.getReqData()

			return ApiResponse.created(this.getReqBody())
		}catch (e) {
			return ApiResponse.error(e)
		}
	}


	async show() {
		try {
			const requestData = await this.getReqData(true)

			return ApiResponse.success(requestData)
		}catch (e) {
			return ApiResponse.error(e)
		}
	}

	async update() {
		try {
			const requestData = await this.getReqData(true)
			return ApiResponse.success(requestData)
		}catch (e) {
			return ApiResponse.error(e)
		}
	}

	async delete() {
		try {
			const requestData = await this.getReqData(true)
			return ApiResponse.deleted()
		}catch (e) {
			return ApiResponse.error(e)
		}
	}
}
