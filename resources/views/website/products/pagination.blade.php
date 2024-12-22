@if ($paginator->lastPage() > 1)
<div class="row page mt-5">
    <div class="col-md-6">
        <p class="page-text">@lang('home.showing') {{$paginator->firstItem()}}–{{$paginator->lastItem()}} @lang('home.of') {{$paginator->total()}} @lang('home.results')</p>
    </div>
    <div class="col-md-6">
        <nav aria-label="Blog Pagination">
            <ul class="pagination style-1">
                @if ($paginator->onFirstPage())
                    <li class="page-item"><a class="page-link active" href="javascript:void(0);">{{$paginator->currentPage()}}</a></li>
                    <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1 )}}"> {{$paginator->currentPage() + 1 }} </a></li>
                    @if ($paginator->lastPage() > 2)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 2 )}}"> {{$paginator->currentPage() + 2 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 3)
                    <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 3 )}}"> {{$paginator->currentPage() + 3 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 4)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 4 )}}"> {{$paginator->currentPage() + 4 }} </a></li>
                    @endif

                    @if ($paginator->lastPage() > 5)

                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a></li>
                    @endif
                    @if ($paginator->currentPage() < $paginator->lastPage() )
                    <li class="page-item"><a class="page-link next" href="{{$paginator->nextPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path>
                                </g>
                            </svg></a></li>
                @endif
                @elseif ($paginator->currentPage() == 2)
                    <li class="page-item"><a class="page-link prev" href="{{$paginator->previousPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g><g id="SVGRepo_iconCarrier"> <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path> </g></svg></a></li>
                    <li class="page-item"><a class="page-link " href="{{$paginator->url($paginator->currentPage() - 1 )}}">{{$paginator->currentPage() - 1}}</a></li>
                    <li class="page-item"><a class="page-link active" href="javascript:void(0);"> {{$paginator->currentPage() }} </a></li>

                    @if ($paginator->lastPage() > 2)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1 )}}"> {{$paginator->currentPage() + 1}} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 3)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 2 )}}"> {{$paginator->currentPage() + 2}} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 4)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 3 )}}"> {{$paginator->currentPage() + 3 }} </a></li>
                    @endif

                    @if ($paginator->lastPage() > 5)
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a></li>
                    @endif
                    @if ($paginator->currentPage() < $paginator->lastPage() )
                    <li class="page-item"><a class="page-link next" href="{{$paginator->nextPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path>
                                </g>
                            </svg></a></li>
                @endif

                @elseif ($paginator->currentPage() > 2 && $paginator->currentPage() < $paginator->lastPage() - 1 )
                    <li class="page-item"><a class="page-link prev" href="{{$paginator->previousPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g><g id="SVGRepo_iconCarrier"> <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path> </g></svg></a></li>

                    @if ($paginator->currentPage() > 3 && $paginator->lastPage() > 5 )
                        <li class="page-item"><a class="page-link" href="{{$paginator->url(1)}}">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                    @endif
                    <li class="page-item"><a class="page-link " href="{{$paginator->url($paginator->currentPage() - 2 )}}">{{$paginator->currentPage() - 2}}</a></li>
                    <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1 )}}"> {{$paginator->currentPage() - 1}} </a></li>
                    <li class="page-item"><a class="page-link active" href="javascript:void(0);"> {{$paginator->currentPage() }} </a></li>
                    @if ($paginator->lastPage() > 3)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1 )}}"> {{$paginator->currentPage() + 1}} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 4)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 2 )}}"> {{$paginator->currentPage() + 2 }} </a></li>
                    @endif

                    @if ($paginator->currentPage() < $paginator->lastPage() - 2 && $paginator->lastPage() > 5  )
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a></li>
                    @endif
                    @if ($paginator->currentPage() < $paginator->lastPage() )
                        <li class="page-item">
                            <a class="page-link next" href="{{$paginator->nextPageUrl()}}">
                                <svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    @endif

                @elseif ($paginator->onLastPage() )
                    @if ($paginator->currentPage() > 1 )
                        <li class="page-item"><a class="page-link prev" href="{{$paginator->previousPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g><g id="SVGRepo_iconCarrier"> <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path> </g></svg></a></li>
                    @endif

                    @if ($paginator->lastPage() > 5)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url(1)}}">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                    @endif

                    @if ($paginator->lastPage() > 4)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 4  )}}"> {{$paginator->currentPage() - 4 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 3)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 3  )}}"> {{$paginator->currentPage() - 3 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 2)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 2  )}}"> {{$paginator->currentPage() - 2 }} </a></li>
                    @endif

                    <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1  )}}"> {{$paginator->currentPage() - 1 }} </a></li>
                    <li class="page-item"><a class="page-link active" href="javascript:void(0);">{{$paginator->currentPage()}}</a></li>

                @elseif ($paginator->currentPage() == $paginator->lastPage() - 1 )
                @if ($paginator->currentPage() > 1 )
                    <li class="page-item"><a class="page-link prev" href="{{$paginator->previousPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" transform="rotate(180)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g><g id="SVGRepo_iconCarrier"> <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path> </g></svg></a></li>
                @endif
                    @if ($paginator->currentPage() > 5)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url(1)}}">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">...</a></li>
                    @endif



                    @if ($paginator->lastPage() > 4)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 3  )}}"> {{$paginator->currentPage() - 3 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 3)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 2  )}}"> {{$paginator->currentPage() - 2 }} </a></li>
                    @endif
                    @if ($paginator->lastPage() > 2)
                        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() - 1  )}}"> {{$paginator->currentPage() - 1 }} </a></li>
                    @endif
                    <li class="page-item"><a class="page-link active" href="javascript:void(0);">{{$paginator->currentPage()}}</a></li>
                    <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage() + 1  )}}"> {{$paginator->currentPage() + 1 }} </a></li>
                    <li class="page-item"><a class="page-link next" href="{{$paginator->nextPageUrl()}}"><svg fill="#000000" height="25" width="25" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="15.36"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M280.875,269.313l-96,64 C182.199,335.094,179.102,336,176,336c-2.59,0-5.184-0.625-7.551-1.891C163.246,331.32,160,325.898,160,320V192 c0-5.898,3.246-11.32,8.449-14.109c5.203-2.773,11.516-2.484,16.426,0.797l96,64C285.328,245.656,288,250.648,288,256 S285.328,266.344,280.875,269.313z M368,320c0,8.836-7.164,16-16,16h-16c-8.836,0-16-7.164-16-16V192c0-8.836,7.164-16,16-16h16 c8.836,0,16,7.164,16,16V320z"></path>
                                    </g>
                                </svg></a></li>
                @endif
            </ul>
        </nav>
    </div>
</div>
@endif
