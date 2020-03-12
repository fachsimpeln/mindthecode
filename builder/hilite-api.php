<?php

     /**
      * hilite.me API Intergration
      */
     class HightlightCode
     {
          public $available_styles = array("autumn", "borland", "bw", "colorful", "default", "emacs", "friendly", "fruity", "manni", "monokai", "murphy", "native", "pastie", "perldoc", "rrt", "tango", "trac", "vim", "vs");

          private $available_lexer = array("ABAP", "ActionScript", "ActionScript 3", "Ada", "ANTLR", "ANTLR With ActionScript Target", "ANTLR With C# Target", "ANTLR With CPP Target", "ANTLR With Java Target", "ANTLR With ObjectiveC Target", "ANTLR With Perl Target", "ANTLR With Python Target", "ANTLR With Ruby Target", "ApacheConf", "AppleScript", "AspectJ", "aspx-cs", "aspx-vb", "Asymptote", "autohotkey", "AutoIt", "Awk", "Base Makefile", "Bash", "Bash Session", "Batchfile", "BBCode", "Befunge", "BlitzMax", "Boo", "Brainfuck", "Bro", "BUGS", "C", "C#", "C++", "c-objdump", "ca65", "CBM BASIC V2", "Ceylon", "CFEngine3", "cfstatement", "Cheetah", "Clojure", "CMake", "COBOL", "COBOLFree", "CoffeeScript", "Coldfusion HTML", "Common Lisp", "Coq", "cpp-objdump", "Croc", "CSS", "CSS+Django/Jinja", "CSS+Genshi Text", "CSS+Lasso", "CSS+Mako", "CSS+Myghty", "CSS+PHP", "CSS+Ruby", "CSS+Smarty", "CUDA", "Cython", "D", "d-objdump", "Darcs Patch", "Dart", "Debian Control file", "Debian Sourcelist", "Delphi", "dg", "Diff", "Django/Jinja", "DTD", "Duel", "Dylan", "Dylan session", "DylanLID", "eC", "ECL", "Elixir", "Elixir iex session", "Embedded Ragel", "ERB", "Erlang", "Erlang erl session", "Evoque", "Factor", "Fancy", "Fantom", "Felix", "Fortran", "FoxPro", "FSharp", "GAS", "Genshi", "Genshi Text", "Gettext Catalog", "Gherkin", "GLSL", "Gnuplot", "Go", "GoodData-CL", "Gosu", "Gosu Template", "Groff", "Groovy", "Haml", "Haskell", "haXe", "HTML", "HTML+Cheetah", "HTML+Django/Jinja", "HTML+Evoque", "HTML+Genshi", "HTML+Lasso", "HTML+Mako", "HTML+Myghty", "HTML+PHP", "HTML+Smarty", "HTML+Velocity", "HTTP", "Hxml", "Hybris", "IDL", "INI", "Io", "Ioke", "IRC logs", "Jade", "JAGS", "Java", "Java Server Page", "JavaScript", "JavaScript+Cheetah", "JavaScript+Django/Jinja", "JavaScript+Genshi Text", "JavaScript+Lasso", "JavaScript+Mako", "JavaScript+Myghty", "JavaScript+PHP", "JavaScript+Ruby", "JavaScript+Smarty", "JSON", "Julia", "Julia console", "Kconfig", "Koka", "Kotlin", "Lasso", "Lighttpd configuration file", "Literate Haskell", "LiveScript", "LLVM", "Logos", "Logtalk", "Lua", "Makefile", "Mako", "MAQL", "Mason", "Matlab", "Matlab session", "MiniD", "Modelica", "Modula-2", "MoinMoin/Trac Wiki markup", "Monkey", "MOOCode", "MoonScript", "Mscgen", "MuPAD", "MXML", "Myghty", "MySQL", "NASM", "Nemerle", "NewLisp", "Newspeak", "Nginx configuration file", "Nimrod", "NSIS", "NumPy", "objdump", "Objective-C", "Objective-C++", "Objective-J", "OCaml", "Octave", "Ooc", "Opa", "OpenEdge ABL", "Perl", "PHP", "PL/pgSQL", "PostgreSQL console (psql)", "PostgreSQL SQL dialect", "PostScript", "POVRay", "PowerShell", "Prolog", "Properties", "Protocol Buffer", "Puppet", "PyPy Log", "Python", "Python 3", "Python 3.0 Traceback", "Python console session", "Python Traceback", "QML", "Racket", "Ragel", "Ragel in C Host", "Ragel in CPP Host", "Ragel in D Host", "Ragel in Java Host", "Ragel in Objective C Host", "Ragel in Ruby Host", "Raw token data", "RConsole", "Rd", "REBOL", "Redcode", "reg", "reStructuredText", "RHTML", "RobotFramework", "RPMSpec", "Ruby", "Ruby irb session", "Rust", "S", "Sass", "Scala", "Scalate Server Page", "Scaml", "Scheme", "Scilab", "SCSS", "Shell Session", "Smali", "Smalltalk", "Smarty", "Snobol", "SourcePawn", "SQL", "sqlite3con", "SquidConf", "Stan", "Standard ML", "systemverilog", "Tcl", "Tcsh", "Tea", "TeX", "Text only", "Treetop", "TypeScript", "UrbiScript", "Vala", "VB.net", "Velocity", "verilog", "VGL", "vhdl", "VimL", "XML", "XML+Cheetah", "XML+Django/Jinja", "XML+Evoque", "XML+Lasso", "XML+Mako", "XML+Myghty", "XML+PHP", "XML+Ruby", "XML+Smarty", "XML+Velocity", "XQuery", "XSLT", "Xtend", "YAML");

          private $style;
          private $lexer;

          function __construct($style = 'native', $lexer = 'php')
          {
               if (!in_array($style, $this->available_styles)) {
                    $style = 'native';
               }
               $this->style = $style;

               if (!in_array($lexer, $this->available_lexer)) {
                    $lexer = 'php';
               }
               $this->lexer = $lexer;
          }

          public function GetHighlightedCode($code, $linenumbers = true)
          {
               $url = 'http://hilite.me/api';

               $params = '?code=' . urlencode($code);
               $params .= '&lexer=' . urlencode(strtolower($this->lexer));
               $params .= '&style=' . urlencode($this->style);
               if ($linenumbers) {
                    $params .= '&linenos=1';
               }

               return file_get_contents($url . $params);
          }
     }
?>
