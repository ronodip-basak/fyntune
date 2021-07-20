@extends('public.layout')

@section('content')
    <div id="main_div" class="container" style="text-align: center;">
        <div id="question_div">
            
        </div>
        <div style="text-align: right; padding: 3rem; display: none" id="next_button">
            <button class="btn btn-primary" onclick="loadNextQuestion()">Next</button>
        </div>

        <form id="details_form" style="display: none;" method="POST" action="{{ route('test.saveResult', $test) }}" >
            <h4>Share your details</h4>
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" value="{{ old('name') }}" required />
                        @error('name')
                            <div class="alert alert-warning">
                                {{ $message }}    
                            </div>   
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required />
                        @error('email')
                            <div class="alert alert-warning">
                                {{ $message }}    
                            </div>   
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input class="form-control" name="phone" type="tel" value="{{ old('phone') }}" required />
                        @error('phone')
                            <div class="alert alert-warning">
                                {{ $message }}    
                            </div>   
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="padding-top: 1rem" class="form-group">
                        
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>

    <script>

        var questions;
        var currentQuestionKey = 0;

        const handleAnswerSelect = (answer) => {
            const myButton = event.target;
            myButton.className = 'btn btn-secondary';
            for (x in document.getElementById('question_div').getElementsByTagName('button')){
                document.getElementById('question_div').getElementsByTagName('button')[x].disabled = true;
                console.log(x)
            }
            fetch(`/api/select_answer/${answer}`, {
                method: 'POST'
            })
                .then(response => response.json())
                .then(response => {
                    if(response.error){
                        alert(`${response.error}`);
                        return;
                    }
                    document.getElementById(`option_${response.id}`).className = 'btn btn-success';
                    if(response.id != answer){
                        document.getElementById(`option_${answer}`).className = 'btn btn-danger';
                    }
                    document.getElementById('next_button').style.display = 'block';
                })
        }

        const fetchQuestions = () => {
            fetch(`{{ route('load_question', $test) }}`)
                .then(response => response.json())
                .then(response => {
                    const finalQuestions = response.data.filter(item => !item.is_answered)
                    if(finalQuestions.length < 1){
                        showFinalSubmitForm();
                        return;
                    }
                    renderQuestion(finalQuestions[currentQuestionKey]);
                    questions = finalQuestions;
                })
        }

        const renderQuestion = (question) => {

            let html = `<div><h4 id="question">${question.question}</h4></div>`;
            question.options.forEach(option => {
                html += `<div class="form-group" style="margin-top: 2rem;"><button id="option_${option.id}" style="width: 20rem; max-width: 100%;" class="btn btn-light" onclick="handleAnswerSelect(${option.id})">${option.value}</button></div>`
            });

            document.getElementById('question_div').innerHTML = html;
        }

        const loadNextQuestion = () => {
            currentQuestionKey++;
            document.getElementById('next_button').style.display = 'none';

            if(currentQuestionKey >= questions.length){
                showFinalSubmitForm();
                return;
            }
            renderQuestion(questions[currentQuestionKey]);
        }

        const showFinalSubmitForm = () => {
            document.getElementById('question_div').style.display = 'none';
            document.getElementById('details_form').style.display = 'block';
        }

        

    </script>

    @if (old('email') == null && old('email') == null && old('phone') == null)
        <script>
            fetchQuestions();
        </script>

    @else
        <style>
            #details_form{
                display: block !important;
            }
        </style>
    @endif
@endsection
