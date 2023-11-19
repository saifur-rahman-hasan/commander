import {NextRequest, NextResponse} from "next/server";

export abstract class ApiController {
	protected request: NextRequest
	protected response: NextResponse
	protected requestSearchParams: any;

	protected constructor(
		req: NextRequest,
		res: NextResponse
	) {
		this.request = req
		this.response = res
		this.requestSearchParams = req.nextUrl.searchParams
	}

	async getReqBody() {
		return await this.request.json()
	}

	validateRequest() {

	}
}

export interface ApiCrudController {
	index(): any;
	create(): any;
	show(id: any): any;
	update(id: any): any;
	delete(id: any): any;
}
