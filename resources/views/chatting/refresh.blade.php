   <style>
       .img-circle {
           background-color: #FFFFFF;
           margin-bottom: 10px;
           padding: 4px;
           border-radius: 50% !important;
           max-width: 100%;
       }

   </style>
   @foreach ($data as $d)
       @if (Auth::user() != '')
           @if ($d->id_pengirim == Auth::user()->id)
               @php
                   $class = 'right';
                   $placeholder = 'https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13';
               @endphp
           @else
               @php
                   $class = 'left';
                   $placeholder = 'https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13';
               @endphp
           @endif
       @endif
       @if (Auth::guard('eksmp')->user() != '')
           @if ($d->id_pengirim == Auth::guard('eksmp')->user()->id)
               @php
                   $class = 'right';
                   $placeholder = 'https://place-hold.it/50x50/FA6F57/fff&text=ME&fontsize=13';
               @endphp
           @else
               @php
                   $class = 'left';
                   $placeholder = 'https://place-hold.it/50x50/55C1E7/fff&text=H&fontsize=13';
                   
               @endphp
           @endif
       @endif
       <li class="{{ $class }} clearfix">
           <span class="chat-img pull-{{ $class }}">
               <img src="{{ $placeholder }}" alt="User Avatar" class="img-circle" />
           </span>
           <div class="chat-body clearfix pull-{{ $class }}">
               <div class="header">
                   <strong class=" text-muted"><span class="pull-{{ $class }} primary-font"></span><b>
                           @if ($d->id_pengirim == $d->admin_user->id)
                               {{ $d->admin_user->name }}
                           @endif

                           @if ($d->company_user->profile != '' && $d->id_pengirim == $d->company_user->id)
                               {{ $d->company_user->profile->company }}
                           @elseif($d->company_user->profile_buyer != '' && $d->id_pengirim == $d->company_user->id)
                               {{ $d->company_user->profile_buyer->company }}
                           @endif

                       </b></strong>
                   <small class="glyphicon glyphicon-time">
                       ({{ date('d-m-Y H:i:s', strtotime($d->created_at)) }})
                   </small>
               </div>
               <p>
                   {{ $d->pesan }}
               </p>
               <p>
                   @if (empty($d->file))
                   @else
                       <br><a target="_BLANK" href="{{ asset('uploads/ChatAdminCompanyFiles/' . $d->file) }}">
                           <font color="green">
                               {{ $d->file }}
                           </font>
                       </a>
                   @endif
               </p>

           </div>
       </li>
   @endforeach
