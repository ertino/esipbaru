@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

        <div class="row">
            <div id="modal-tungguproses-content" style="display: none;">
                <center>
                <i class="fas fa-hourglass"></i>
                <h5>Mohon Tunggu..</h5>
                </center>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-md-5">
                <!-- DIRECT CHAT PRIMARY -->
                <div class="card card-primary card-outline direct-chat direct-chat-primary">
                    <div class="card-header">
                    <h3 class="card-title">Direct Chat</h3>

                    <div class="card-tools">
                        <span title="3 New Messages" class="badge bg-primary">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" id="chatMessages">
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg">
                        
                        <div class="direct-chat-text">
                            Hallo, Bisa Dibantu?
                        </div>
                        <!-- /.direct-chat-text -->
                        </div>
                        <!-- /.direct-chat-msg -->

                        
                    </div>
                  
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    <form action="#" id="aichat" method="post">
                        <div class="input-group">
                        <input type="text" name="message" id="chatInput" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button type="submit" id="{{$user_id}}" class="btn btn-primary">Send</button>
                        </span>
                        </div>
                    </form>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!--/.direct-chat -->
            </div>
            <div class="col-md-12">
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
</div>

@endsection
@section('js')

@endsection

@section('script')
<script>

    $(function() {
        const $chatMessages = $('#chatMessages');

        $('#aichat').on('submit', function(e) {
            e.preventDefault();

            var sessionId = $(this).attr('id')
            const msg = $('#chatInput').val().trim();
            if (!msg) return;

            // append user message
            $chatMessages.append(`
            <div class="direct-chat-msg right">
                <div class="direct-chat-text bg-primary text-white">${msg}</div>
            </div>
            `);
            $('#chatInput').val('');
            $chatMessages.scrollTop($chatMessages[0].scrollHeight);

            // Send message to your Laravel controller that forwards to n8n
            $.ajax({
                url: '{{ route("chatwithai") }}',
                method: 'POST',
                data: {
                    'chatInput': msg,
                    'sessionId' : sessionId,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend() {
                    $chatMessages.append(`
                    <div class="direct-chat-msg">
                        <div class="direct-chat-text bg-light text-muted"><i>AI is typing...</i></div>
                    </div>
                    `);
                    $chatMessages.scrollTop($chatMessages[0].scrollHeight);
                },
                success(res) {
                    // remove "typing" message
                    $chatMessages.find('.direct-chat-text:contains("AI is typing")').parent().remove();

                    const aiReply = res.answer || res.reply || JSON.stringify(res);
                    $chatMessages.append(`
                    <div class="direct-chat-msg">
                        <div class="direct-chat-text">${aiReply}</div>
                    </div>
                    `);
                    $chatMessages.scrollTop($chatMessages[0].scrollHeight);
                },
                error(err) {
                    $chatMessages.append(`
                    <div class="direct-chat-msg">
                        <div class="direct-chat-text bg-danger text-white">Error contacting AI.</div>
                    </div>
                    `);
                }
            });
        });
    });

</script>
@endsection

